<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyerMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $id;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $from;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $action;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $from, $message, $action)
    {
        $this->id       = $id;
        $this->from     = $from;
        $this->action   = $action;
        $this->message  = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chatBuyer.' . $this->id);
    }
}
