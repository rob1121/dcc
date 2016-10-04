<?php

namespace App\Jobs;

use App\CompanySpec;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserForSpecUpdate implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var CompanySpec
     */
    private $spec;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CompanySpec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return (new MailMessage)
            ->subject("Internal spec update: {$this->spec->spec_no}")
            ->line("Changes:")
            ->line("{$this->spec->companySpecRevision->revision_summary}")
            ->action('View it now', url('/'))
            ->success()
            ->line('Feel free to contance me');
    }
}
