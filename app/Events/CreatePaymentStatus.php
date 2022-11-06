<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatePaymentStatus implements ShouldBroadcast
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
    public $asset;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $paymentStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $asset, $paymentStatus)
    {
        $this->id            = $id;
        $this->asset         = $asset;
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('payment.status.' . $this->id);
    }
}
