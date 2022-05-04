<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\MailerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Webklex\IMAP\Exceptions\ConnectionFailedException;
use Webklex\IMAP\Exceptions\MaskNotFoundException;
use Webklex\IMAP\IMAP;

class MailerController extends Controller
{
    private $allowedMailSettings = [
        'income_mail_protocol',
        'income_server',
        'income_port',
        'income_encryption',
        'smtp_server',
        'smtp_port',
        'smtp_encryption',
        'email_server_username',
        'email_server_password',
    ];

    /**
     * Show main folder with messages
     *
     * @param bool    $folderName
     * @return Application|Factory|\Illuminate\View\View
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function index(Request $request, $folderName = false)
    {
        $user          = Auth::user();
        $mailerService = new MailerService($user);
        if ($mailerService->isValidIncomeMailConfiguration()) {
            $mailerService->connectToIncomeServer();
        }

        $incomeMailClient = $mailerService->getIncomeMailClient();
        $folders          = $mailerService->getFolders();
        if ($folderName) {
            $serverFolderName = $mailerService->getServerFolderName($folderName, $folders);
            $currentFolder    = $mailerService->getFolder($serverFolderName);
        } else {
            $currentFolder = $mailerService->getDefaultFolder();
        }

        $page = $request->get('page', 1);
        $messages = $mailerService->getMessagesFromFolder($currentFolder, $page);

        return view('mailer.index', compact('user', 'incomeMailClient', 'folders', 'messages', 'currentFolder'));
    }

    /**
     * Show message
     *
     * @param $folderName
     * @param $uid
     * @return Application|Factory|\Illuminate\View\View
     * @throws MaskNotFoundException
     * @throws ConnectionFailedException
     */
    public function message($folderName, $uid)
    {
        $user          = Auth::user();
        $mailerService = new MailerService($user, true);
        $mailerService->connectToIncomeServer();

        $folders          = $mailerService->getFolders();
        $incomeMailClient = $mailerService->getIncomeMailClient();
        $serverFolderName = $mailerService->getServerFolderName($folderName, $folders);
        $currentFolder    = $mailerService->getFolder($serverFolderName);
        $message          = $mailerService->getMessage($uid, $currentFolder);
        $smtpStatus       = $mailerService->checkSMTPConnection();
        $toAll            = $mailerService->getAllReplyRecipients($message);

        return view(
            'mailer.message',
            compact('message', 'currentFolder', 'folders', 'incomeMailClient', 'smtpStatus', 'toAll')
        );
    }

    /**
     * Download attachment from email
     *
     * @param $folderName
     * @param $uid
     * @param $attachmentId
     * @return StreamedResponse
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function attachment($folderName, $uid, $attachmentId): StreamedResponse
    {
        $user          = Auth::user();
        $mailerService = new MailerService($user);
        $mailerService->connectToIncomeServer();

        $folders          = $mailerService->getFolders();
        $serverFolderName = $mailerService->getServerFolderName($folderName, $folders);
        $currentFolder    = $mailerService->getFolder($serverFolderName);
        $message          = $mailerService->getMessage($uid, $currentFolder);
        $attachments      = $message->getAttachments();
        $attachment       = $mailerService->getAttachment($attachments, $attachmentId);

        if ($attachment === false) {
            abort(404, 'Something went wrong');
        }

        return response()->streamDownload(
            function () use ($attachment) {
                echo $attachment->content;
            },
            $attachment->name
        );
    }

    /**
     * Send new message from user
     *
     * @param Request $request
     * @return JsonResponse
     * @throws MaskNotFoundException
     */
    public function send(Request $request): JsonResponse
    {
        $user          = Auth::user();
        $mailerService = new MailerService($user);

        $validator = Validator::make(
            $request->all(),
            [
                'to'            => 'required|email',
                'subject'       => 'required',
                'message'       => 'required',
                'attachments'   => 'max:5',
                'attachments.*' => 'max:1000',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $to          = $request->post('to');
        $subject     = $request->post('subject');
        $message     = $request->post('message');
        $attachments = $request->file('attachments', []);

        if ($mailerService->sendSMTPMessage($to, $subject, $message, $attachments)) {
            $request->session()->flash('msg-success', trans('mailer.message_sent'));

            return response()->json(['status' => 'success', 'errors' => [], 'redirect' => route('mailer.index')]);
        }

        return response()->json(
            ['status' => 'error', 'errors' => ['send' => trans('mailer.error_sending_message')]],
            500
        );
    }

    /**
     * Show new message form
     *
     * @return Application|Factory|\Illuminate\View\View
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function newMessage()
    {
        $user          = Auth::user();
        $mailerService = new MailerService($user);
        $mailerService->connectToIncomeServer();

        $incomeMailClient = $mailerService->getIncomeMailClient();
        $currentFolder    = $mailerService->getDefaultFolder();
        $folders          = $mailerService->getFolders();
        $smtpStatus       = $mailerService->checkSMTPConnection();

        return view('mailer.message', compact('currentFolder', 'folders', 'incomeMailClient', 'smtpStatus'));
    }

    /**
     * Update mail configuration
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSettings(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'income_mail_protocol' => 'required|in:imap,pop3,nntp',
                'income_server'        => 'required',
                'income_port'          => 'required|numeric',
                'income_encryption'    => 'required|in:0,ssl,tls,starttls,notls',
                'smtp_server'          => 'required',
                'smtp_port'            => 'required|numeric',
                'smtp_encryption'      => 'required|in:0,ssl,tls,starttls,notls',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $user             = Auth::user();
        $emailSererFields = $request->only($this->allowedMailSettings);
        $user->meta_data  = array_merge($user->meta_data, $emailSererFields);
        $user->save();

        $request->session()->flash('msg-success', trans('all.changes_successfully_saved'));

        return response()->json(['result' => 'true', 'redirect' => route('mailer.index')]);
    }
}
