<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent
{
    use Dispatchable, SerializesModels;

    public $notification;
    public $receiverId;

    /**
     * Create a new event instance.
     *
     * @param array $notification
     * @param int $receiverId
     */
    public function __construct($notification, $receiverId)
    {
        $this->notification = $notification;
        $this->receiverId = $receiverId;
    }
}