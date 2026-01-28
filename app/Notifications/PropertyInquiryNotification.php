<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PropertyInfo;

class PropertyInquiryNotification extends Notification
{
    use Queueable;

    protected $inquiry;
    protected $property;

    /**
     * Create a new notification instance.
     */
    public function __construct($inquiry, PropertyInfo $property)
    {
        $this->inquiry = $inquiry;
        $this->property = $property;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = route('track-inquiry', ['id' => $this->inquiry->id]);
        
        return (new MailMessage)
            ->subject('New Property Inquiry: ' . $this->property->PropertyName)
            ->greeting('Hello ' . ($notifiable->UserName ?? 'Team') . ',')
            ->line('You have received a new organic inquiry for the property: ' . $this->property->PropertyName)
            ->line('Lead Details:')
            ->line('Name: ' . $this->inquiry->UserName)
            ->line('Email: ' . $this->inquiry->Email)
            ->line('Phone: ' . ($this->inquiry->Phone ?? 'N/A'))
            ->line('Desired Move Date: ' . ($this->inquiry->MoveDate ?? 'N/A'))
            ->line('Message: ' . ($this->inquiry->Message ?? 'No message provided.'))
            ->action('Respond to Inquiry', $loginUrl)
            ->line('Please respond promptly to ensure conversion!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'inquiry_id' => $this->inquiry->id,
            'title' => 'New Organic Inquiry',
            'message' => 'New inquiry from <strong>' . $this->inquiry->UserName . '</strong> for <strong>' . $this->property->PropertyName . '</strong>',
            'notification_link' => route('track-inquiry', ['id' => $this->inquiry->id]),
            'property_id' => $this->property->Id
        ];
    }
}
