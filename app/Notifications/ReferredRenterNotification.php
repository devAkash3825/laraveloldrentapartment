<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Login;
use App\Models\PropertyInfo;

class ReferredRenterNotification extends Notification
{
    use Queueable;

    protected $renter;
    protected $property;
    protected $admin;

    /**
     * Create a new notification instance.
     */
    public function __construct(Login $renter, PropertyInfo $property, $admin)
    {
        $this->renter = $renter;
        $this->property = $property;
        $this->admin = $admin;
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
        $renterName = ($this->renter->renterinfo->Firstname ?? '') . ' ' . ($this->renter->renterinfo->Lastname ?? '');
        $adminName = $this->admin->admin_name ?? 'An Agent';
        
        return (new MailMessage)
            ->subject('New Referral: ' . $renterName)
            ->greeting('Hello ' . ($notifiable->UserName ?? 'Manager') . ',')
            ->line($adminName . ' has referred a new renter to your property: ' . $this->property->PropertyName)
            ->line('Renter Details:')
            ->line('Name: ' . $renterName)
            ->line('Email: ' . $this->renter->Email)
            ->line('Phone: ' . ($this->renter->renterinfo->phone ?? 'N/A'))
            ->action('View Renter Profile', route('manager-message', ['p_id' => $this->property->Id, 'r_id' => $this->renter->Id]))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $renterName = ($this->renter->renterinfo->Firstname ?? '') . ' ' . ($this->renter->renterinfo->Lastname ?? '');
        $adminName = $this->admin->admin_name ?? 'Admin';
        
        return [
            'from_id' => $this->admin->id,
            'from_user_type' => 'A',
            'title' => 'Referred Renter',
            'message' => '<strong>' . $adminName . '</strong> has referred <strong>' . $renterName . '</strong> to you for <strong>' . $this->property->PropertyName . '</strong>',
            'notification_link' => route('manager-message', ['p_id' => $this->property->Id, 'r_id' => $this->renter->Id]),
            'property_id' => $this->property->Id,
            'renter_id' => $this->renter->Id
        ];
    }
}
