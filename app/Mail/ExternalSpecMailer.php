<?php

namespace App\Mail;

use App\CustomerSpec;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExternalSpecMailer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $mail_subject;
    public $data = [];

    /**
     * Create a new message instance.
     * @param CustomerSpec $spec
     * @param $caption
     */
    public function __construct(CustomerSpec $spec, $caption)
    {
        $rev = collect($spec->customerSpecRevision)->sortBy("revision")->last()->revision;
        $this->mail_subject = \Str::upper("{$caption} {$spec->spec_no} {$rev}");
        $this->data = [
            "spec" => $spec,
            "sub_title" => config("dcc.sub_title", ""),
            "system" => config("dcc.title", ""),
            "route" => config("app.url") . "/external/{$spec->id}"
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mail_subject)->view('emails.mail_external_spec_for_review');
    }
}
