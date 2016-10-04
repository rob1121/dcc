<?php

namespace App\Events;

use App\CompanySpec;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SomeEvent {
    use SerializesModels;
    /**
     * @var CompanySpec
     */
    public $spec;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CompanySpec $spec)
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
