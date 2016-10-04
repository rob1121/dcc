<?php

namespace App\Notifications;

use App\CompanySpec;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;

class InternalSpecUpdateNotifier extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    private $spec;

    public function __construct(CompanySpec $spec)
    {
        $this->spec = $spec;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Internal spec update: {$this->spec->spec_no} - {$this->spec->name}")
            ->line("Revision summary:")
            ->line("{$this->spec->companySpecRevision->revision_summary}")
            ->action('View it now', url('/'))
            ->success()
            ->line('Feel free to contance me');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
