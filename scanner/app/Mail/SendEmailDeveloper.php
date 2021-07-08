<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailDeveloper extends Mailable
{
    use Queueable, SerializesModels;
    public $datas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

    	return $this->subject('Install Ngagge')->view('emails.Codetodeveloper');
        //return $this->view('emailsGandhi');
    }
}