<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PropertyInfo;

class ManagerNoteNotification extends Notification
{
    use Queueable;

    protected $manager;
    protected $property;
    protected $message;

    public function __construct($manager, PropertyInfo $property, $message)
    {
        $this->manager = $manager;
        $this->property = $property;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $managerName = $this->manager->UserName ?? 'Property Manager';
        
        return (new MailMessage)
            ->subject('Update regarding ' . $this->property->PropertyName)
            ->greeting('Hello ' . ($notifiable->UserName ?? 'User') . ',')
            ->line('A message has been posted regarding the property ' . $this->property->PropertyName)
            ->line('Message from ' . $managerName . ':')
            ->line('"' . $this->message . '"')
            ->action('View Conversation', route('send-messages', ['id' => $this->property->Id]))
            ->line('Thank you for choosing us for your rental search!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'from_id' => $this->manager->Id,
            'from_user_type' => 'M',
            'title' => 'New Message from Manager',
            'message' => 'Manager <strong>' . $this->manager->UserName . '</strong> sent a message for <strong>' . $this->property->PropertyName . '</strong>',
            'notification_link' => route('send-messages', ['id' => $this->property->Id]),
            'property_id' => $this->property->Id
        ];
    }
}
