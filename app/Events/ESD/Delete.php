<?php

namespace App\Events\ESD;

use App\ESD;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class Delete
{
    use InteractsWithSockets, SerializesModels;
    public $spec_title;

    /**
     * Create a new event instance.
     *
     * @param $spec_title
     */
    public function __construct($spec_title)
    {
        $this->spec_title = $spec_title;
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
