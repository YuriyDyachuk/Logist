<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\User;
use Webklex\IMAP\Exceptions\ConnectionFailedException;
use Webklex\IMAP\Exceptions\GetMessagesFailedException;
use Webklex\IMAP\Exceptions\MailboxFetchingException;
use Webklex\IMAP\Exceptions\MaskNotFoundException;
use Webklex\IMAP\IMAP;
use Webklex\IMAP\Support\FolderCollection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerService
{
    private $oClient;

    private $user;

    private $markAsRead;

    /**
     * MailerService constructor.
     * @param User $user
     * @param bool $markAsRead
     * @throws MaskNotFoundException
     */
    public function __construct(User $user, $markAsRead = false)
    {
        $this->user = $user;

        $config = $this->getIncomeMailConfig();
        $this->oClient = new MailerClient($config);
        $this->markAsRead = $markAsRead;
    }

    /**
     * Connect to income mail server
     */
    public function connectToIncomeServer():void
    {
        try {
            // Fixed timeout-s time, in order not to cause an error max execution time
            // And give the user the opportunity to correct the wrong configuration if he made a mistake
            $this->oClient->setTimeout(IMAP::IMAP_OPENTIMEOUT, config('imap.timeouts.open'));
            $this->oClient->setTimeout(IMAP::IMAP_READTIMEOUT, config('imap.timeouts.read'));
            $this->oClient->setTimeout(IMAP::IMAP_CLOSETIMEOUT, config('imap.timeouts.close'));
            $this->oClient->connect(1);
        } catch (ConnectionFailedException | \Exception $exception) {
            $this->oClient->connectionErorrs[] = $exception->getMessage();
        }
    }

    /**
     * Validate income mail config before connect
     *
     * @return bool
     */
    public function isValidIncomeMailConfiguration():bool
    {
        $config = $this->getIncomeMailConfig();
        if (empty($config['host']) || empty($config['port'])) {
            $this->oClient->connectionErorrs[] = trans('mailer.income_mail_empty_configuration');
            return false;
        }

        return true;
    }

    /**
     * Return income mail client
     *
     * @return mixed
     */
    public function getIncomeMailClient():MailerClient
    {
        return $this->oClient;
    }

    /**
     * Return list of all folders
     *
     * @return FolderCollection
     * @throws ConnectionFailedException
     */
    public function getFolders():FolderCollection
    {
        if ($this->oClient->connection === false) {
            return FolderCollection::make([]);
        }

        try {
            $folders = $this->oClient->getFolders();
            return $this->fixFoldersDelimiter($folders);
        } catch (MailboxFetchingException $exception) {
            $this->oClient->fetchFoldersErrors[] = $exception->getMessage();
            return FolderCollection::make([]);
        }
    }

    /**
     * Get folder by name
     *
     * @param $folderName
     * @return bool|FolderCollection
     */
    public function getFolder($folderName)
    {
        if ($this->oClient->connection === false) {
            return FolderCollection::make([]);
        }

        try {
            $folder = $this->oClient->getFolder($folderName);
            return $this->fixFolderDelimiter($folder);
        } catch (MailboxFetchingException $exception) {
            $this->oClient->fetchFoldersErrors[] = $exception->getMessage();
            return false;
        }
    }

    /**
     * Return default folder from all folders list
     *
     * @return Collection|mixed
     * @throws ConnectionFailedException
     */
    public function getDefaultFolder()
    {
        $folders = $this->getFolders();
        if ($folders->count() === 0) {
            return collect();
        }

        return $folders->first();
    }

    /**
     * Return message collection from selected folder
     *
     * @param $folder
     * @param int $page
     * @return mixed
     */
    public function getMessagesFromFolder($folder, $page = 1)
    {
        if ($this->oClient->connection === false) {
            return collect();
        }

        try {
            $query = $folder->search();
            if ($this->markAsRead) {
                $query->markAsRead();
            } else {
                $query->leaveUnread();
            }

            $perPage = config('imap.per_page', 10);
            $messages = collect($query->limit($perPage, $page)->setFetchBody(false)->get());

            return new LengthAwarePaginator(
                $messages,
                $folder->getStatus(IMAP::SA_ALL)->messages,
                $perPage,
                $page,
                [
                    'path'=> route('mailer.folder', $folder->full_name_url)
                ]
            );
        } catch (GetMessagesFailedException | \Exception $exception) {
            $this->oClient->fetchFoldersErrors[] = $exception->getMessage();
            return collect();
        }
    }

    /**
     * Fix folders name delimiter, for example, when '/' used in smtp server (gmail tested)
     *
     * @param $folders
     * @return FolderCollection
     */
    private function fixFoldersDelimiter($folders):FolderCollection
    {
        $fixedFolders = FolderCollection::make();
        foreach ($folders as $folder) {
            $fixedFolders[] = $this->fixFolderDelimiter($folder);
            if ($folder->has_children) {
                $folder->children = $this->fixFoldersDelimiter($folder->children);
            }
        }

        return $fixedFolders;
    }

    /**
     * Fix - folder delimiter, when when '/' used in smtp server (for example gmail)
     * Fix - folder names with some type of names (for example cyrillic folder names)
     *
     * @param $folder
     * @return mixed
     */
    private function fixFolderDelimiter($folder)
    {
        preg_match('#\{(.*)\}(.*)#', $folder->path, $preg);
        $folder->full_name_url = str_replace('/', config('imap.options.delimiter'), $preg[2]);

        return $folder;
    }

    /**
     * Get folder name, with server-side delimiter
     *
     * @param $folderName
     * @param $folders
     * @return string
     */
    public function getServerFolderName($folderName, $folders):string
    {
        $serverDelimiter = $folders->first() ? $folders->first()->delimiter : config('imap.options.delimiter');

        if (config('imap.options.delimiter') === $serverDelimiter) {
            return $folderName;
        }

        return str_replace(config('imap.options.delimiter'), $serverDelimiter, $folderName);
    }

    /**
     * Return message, by uid, from selected folder
     *
     * @param $uid
     * @param $folder
     * @return mixed
     */
    public function getMessage($uid, $folder)
    {
        if ($this->oClient->connection === false) {
            return false;
        }

        try {
            return $folder->getMessage($uid, null, null, true, true, true);
        } catch (GetMessagesFailedException | \Exception $exception) {
            $this->oClient->fetchFoldersErrors[] = $exception->getMessage();
            return false;
        }
    }

    /**
     * Get attachment by id, from all attachment list
     *
     * @param $attachments
     * @param $attachmentId
     * @return bool|mixed
     */
    public function getAttachment($attachments, $attachmentId)
    {
        foreach ($attachments as $attachment) {
            if ($attachment->id === $attachmentId) {
                return $attachment;
            }
        }

        return false;
    }

    /**
     * Return income mail configuration
     *
     * @return array
     */
    private function getIncomeMailConfig():array
    {
        $encryption = $this->user->meta_data['income_encryption'] ?? false;
        if ($encryption === '0') {
            $encryption = false;
        }

        return [
            'protocol'      => $this->user->meta_data['income_mail_protocol'] ?? '',
            'host'          => $this->user->meta_data['income_server'] ?? '',
            'port'          => $this->user->meta_data['income_port'] ?? '',
            'encryption'    => $encryption,
            'username'      => $this->user->meta_data['email_server_username'] ?? '',
            'password'      => $this->user->meta_data['email_server_password'] ?? '',
        ];
    }

    /**
     * Return SMTP settings configuration for current user
     *
     * @return array
     */
    private function getSMTPConfig():array
    {
        $config = [
            'server'   => $this->user->meta_data['smtp_server'] ?? '',
            'port'     => $this->user->meta_data['smtp_port'] ?? '',
            'username' => $this->user->meta_data['email_server_username'] ?? '',
            'password' => $this->user->meta_data['email_server_password'] ?? '',
        ];

        $config['encryption'] = $this->user->meta_data['smtp_encryption'] ?? null;
        if ($config['encryption']  === '0') {
            $config['encryption']  = null;
        }

        return $config;
    }

    /**
     * Check SMTP settings
     *
     * @return bool
     */
    public function checkSMTPConnection():bool
    {
        try{
            $config = $this->getSMTPConfig();
            $transport = new \Swift_SmtpTransport($config['server'], $config['port'], $config['encryption']);

            $transport->setUsername($config['username']);
            $transport->setPassword($config['password']);

            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->setTimeout(10)->start();
            return true;
        } catch (\Swift_TransportException | \Exception $e) {
            return false;
        }
    }

    /**
     * Send message via SMTP protocol
     *
     * @param $to
     * @param $subject
     * @param $message
     * @param $attachments
     * @return bool
     */
    public function sendSMTPMessage($to, $subject, $message, $attachments):bool
    {
        try {
            $config = $this->getSMTPConfig();

            $mail = new PHPMailer(true);

            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = $config['server'];
            $mail->Port       = $config['port'];
            if (empty($config['username']) && empty($config['password'])) {
                $mail->SMTPAuth = false;
            } else {
                $mail->SMTPAuth = true;
            }

            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            if ($config['encryption'] !== null) {
                $mail->SMTPSecure = $config['encryption'];
            }

            $mail->setFrom($config['username']);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            foreach ($attachments as $attachment) {
                $mail->AddAttachment($attachment->getPathName(), $attachment->getClientOriginalName());
            }

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get all reply recipients
     *
     * @param $message
     * @return array
     */
    public function getAllReplyRecipients($message):array
    {
        $toAll = array_column($message->to, 'mail');
        $toAll[] = $message->from[0]->mail;

        $userMail = $this->user->meta_data['email_server_username'] ?? '';

        $key = array_search($userMail, $toAll, false);
        if ($key !== false && isset($toAll[$key])) {
            unset($toAll[$key]);
        }

        return $toAll;
    }
}
