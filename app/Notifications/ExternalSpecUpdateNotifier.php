<?php namespace App\Notifications;

use App\CustomerSpec;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExternalSpecUpdateNotifier extends Notification implements ShouldQueue
{
    use Queueable;

    private $spec;
    private $caption;

    public function __construct(CustomerSpec $spec, $caption)
    {
        $this->spec = $spec;
        $this->caption = $caption;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("{$this->caption}: {$this->spec->spec_no} - {$this->spec->name}")
            ->line("<strong>Name:</strong> {$this->spec->name}")
            ->line("<strong>Revision:</strong> {$this->spec->customerSpecRevision->revision}")
            ->line("<strong>Date:</strong> {$this->spec->customerSpecRevision->revision_date}")
            ->action('View it now', url('/'))
            ->success()
            ->line('Feel free to contance me');
    }
}
