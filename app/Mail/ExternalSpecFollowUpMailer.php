<?php

namespace App\Mail;

use App\CustomerSpec;
use App\CustomerSpecRevision;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExternalSpecFollowUpMailer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $mail_subject;
    public $data = [];

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->mail_subject = \Str::upper("FOLLOW UP: list of customer specs for review");
        $this->data = [
            "specs" => CustomerSpec::forReview(),
            "sub_title" => config("dcc.sub_title", ""),
            "system" => config("dcc.title", ""),
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mail_subject)->view('emails.mail_external_spec_for_followup');
    }
}
