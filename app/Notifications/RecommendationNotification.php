<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PropertyInfo;

class RecommendationNotification extends Notification
{
    use Queueable;

    protected $property;
    protected $admin;

    public function __construct(PropertyInfo $property, $admin)
    {
        $this->property = $property;
        $this->admin = $admin;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $adminName = $this->admin->admin_name ?? 'Your Agent';
        
        return (new MailMessage)
            ->subject('Premium Recommendation: ' . $this->property->PropertyName)
            ->greeting('Hello ' . ($notifiable->UserName ?? 'Renter') . ',')
            ->line('Your expert locator ' . $adminName . ' has specifically selected a property for you that matches your criteria.')
            ->line('Recommended Property: ' . $this->property->PropertyName)
            ->line('Location: ' . ($this->property->city->CityName ?? 'N/A'))
            ->action('View Full Details & Photos', route('property-display', ['id' => $this->property->Id]))
            ->line('This property is moving fast. Reach out if you have any questions!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'from_id' => $this->admin->id,
            'from_user_type' => 'A',
            'title' => 'New Recommendation',
            'message' => 'Your agent has recommended <strong>' . $this->property->PropertyName . '</strong> to you.',
            'notification_link' => route('property-display', ['id' => $this->property->Id]),
            'property_id' => $this->property->Id
        ];
    }
}
