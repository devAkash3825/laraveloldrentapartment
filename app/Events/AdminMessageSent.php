<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;
    public $receiverid;
    public $propertyid;
    public function __construct($notification,$receiverid,$propertyid)
    {
        
        $this->notification = $notification;
        $this->receiverid = $receiverid;
        $this->propertyid = $propertyid;
    }

    public function broadcastAs()
    {
        return 'AdminMessageSent';
    }
   
    public function broadcastOn()
    {
        return new PrivateChannel('message-from-admin.'.$this->receiverid);
        
    }
}
