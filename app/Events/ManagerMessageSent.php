<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManagerMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $propertyId;
    public $renterId;
    public $adminId;

    public function __construct($message, $propertyId, $renterId, $adminId)
    {
        $this->message = $message;
        $this->propertyId = $propertyId;
        $this->renterId = $renterId;
        $this->adminId = $adminId;
    }

    public function broadcastAs()
    {
        return 'ManagerMessageSent';
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('message-from-manager.' . $this->renterId),
            new PrivateChannel('message-from-manager.' . $this->adminId)
        ];
    }
}
