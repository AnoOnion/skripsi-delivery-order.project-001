<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateOrderStatus implements ShouldBroadcast
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
    public $courierId;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $courierCost;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $orderStatus;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $courierStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $courierId, $courierCost, $orderStatus, $courierStatus)
    {
        $this->id            = $id;
        $this->courierId     = $courierId;
        $this->courierCost   = $courierCost;
        $this->orderStatus   = $orderStatus;
        $this->courierStatus = $courierStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order.status.' . $this->id);
    }
}
