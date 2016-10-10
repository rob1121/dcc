<?php

namespace App\Mail;

use App\CompanySpec;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSpecNewUpdate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $system = "DCC System";
    private $spec;

    /**
     * Create a new message instance.
     *
     * @param CompanySpec $spec
     */
    public function __construct(CompanySpec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.specs_update');
    }
}
