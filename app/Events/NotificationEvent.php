<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $receiverId;


    public function __construct($notification, $receiverId)
    {
        $this->notification = $notification;
        $this->receiverId = $receiverId;
    }

    public function broadcastAs()
    {
        return 'NotificationEvent';
    }
    

    public function broadcastOn()
    {
        return new PrivateChannel('adminNotification.' . $this->receiverId);
    }


}


?>