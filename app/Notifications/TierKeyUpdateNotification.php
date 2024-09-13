<?php

namespace App\Notifications;

use App\Models\UserTierKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TierKeyUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tierKey;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\UserTierKey  $tierKey
     * @return void
     */
    public function __construct(UserTierKey $tierKey)
    {
        $this->tierKey = $tierKey;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The required fields for your tier have been updated.')
            ->line('Please review and update your profile to meet the new requirements.')
            ->action('Update Profile', url('/profile'))
            ->line('Thank you for keeping your information up-to-date!');
    }

    /**
     * Get the array representation of the notification (database storage).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tier_key_id' => $this->tierKey->id,
            'message' => 'The required fields for your tier have been updated.',
        ];
    }
}
