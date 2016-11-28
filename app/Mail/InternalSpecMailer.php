<?php namespace App\Mail;

use App\CompanySpec;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InternalSpecMailer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $mail_subject;
    public $data = [];

    /**
     * Create a new message instance.
     *
     * @param CompanySpec $spec
     * @param $caption
     */
    public function __construct(CompanySpec $spec, $caption)
    {
        $this->mail_subject = \Str::upper("{$caption} {$spec->spec_id} {$spec->companySpecRevision->revision}");
        $this->data = [
            "spec" => $spec,
            "sub_title" => config("dcc.sub_title", ""),
            "system" => config("dcc.title", ""),
            "caption" => $caption,
            "route" => config("app.url") . "/internal/{$spec->id}"
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mail_subject)->view('emails.mail_internal_spec_update');
    }
}
