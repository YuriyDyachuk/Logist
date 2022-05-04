<?php

namespace App\Services;

use \Webklex\IMAP\Client;

class MailerClient extends Client
{
    public $connectionErorrs = [];

    public $fetchFoldersErrors = [];

    public function convertSubjectEncoding($subject)
    {
        $encoding = mb_detect_encoding($subject);
        if($encoding !== 'UTF-8') {
            return iconv_mime_decode($subject, 0, 'UTF-8');
        }

        return $subject;
    }
}
