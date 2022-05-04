<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImproveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $files;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $files)
    {
        $this->data = $data;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = $this->view('emails.new.improve', ['title'=> trans('all.improve_system'), 'data' => $this->data]);

        if(count($this->files) > 0){
            foreach($this->files as $file) {
                $msg->attach($file->getRealPath(), array(
                        'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name
                        'mime' => $file->getMimeType())
                );
            }
        }

        return $msg;
    }
}
