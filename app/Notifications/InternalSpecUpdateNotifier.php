<?php namespace App\Notifications;

use App\CompanySpec;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InternalSpecUpdateNotifier extends Notification implements ShouldQueue
{
    use Queueable;

    private $spec;
    private $caption;

    public function __construct(CompanySpec $spec, $caption)
    {
        $this->spec = $spec;
        $this->caption = $caption;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("{$this->caption}: {$this->spec->spec_no} - {$this->spec->name}")
            ->line("Specification No.: {$this->spec->spec_no}")
            ->line("Document Title: {$this->spec->name}")
            ->line("Revision: {$this->spec->companySpecRevision->revision}")
            ->line("Summary of Changes:")
            ->line("{$this->spec->companySpecRevision->revision_summary}")
            ->line(" ")
            ->line(" ")
            ->action('View it now', url('/'))
            ->success()
            ->line('Feel free to contance me');
    }
}
