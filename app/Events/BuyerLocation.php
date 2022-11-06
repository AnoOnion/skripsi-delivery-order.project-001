<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyerLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * Message details
     *
     * @var Message
     */
    public $status;

    /**
     * Message details
     *
     * @var Message
     */
    public $courierId;

    /**
     * Message details
     *
     * @var Message
     */
    public $location;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $status, $courierId, $location)
    {
        $this->user      = $user;
        $this->status    = $status;
        $this->courierId = $courierId;
        $this->location  = $location;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('buyer');
    }
}
