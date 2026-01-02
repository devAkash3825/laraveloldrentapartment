<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RenterMessageSent implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $notification;
    public $adminId;
    public $propertyId;

    public function __construct($notification,$propertyId,$adminId)
    {
        $this->notification = $notification;
        $this->propertyId = $propertyId;
        $this->adminId = $adminId;
    }

    public function broadcastAs()
    {
        return 'RenterMessageSent';
    }
    

    public function broadcastOn()
    {
        return new PrivateChannel('message-from-renter.'.$this->adminId);
        
    }

}
