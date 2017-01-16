<?php

namespace App\Events\ESD;

use App\ESD;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class Show
{
    use InteractsWithSockets, SerializesModels;
    public $spec;

    /**
     * Create a new event instance.
     *
     * @param $spec
     */
    public function __construct(ESD $spec)
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
