<?php namespace App\Events\user;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class Update
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var User
     */
    private $spec;

    /**
     * Create a new event instance.
     *
     * @param User $spec
     */
    public function __construct(User $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
