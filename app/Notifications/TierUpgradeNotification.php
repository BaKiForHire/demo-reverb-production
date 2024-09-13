<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TierUpgradeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tierId;

    /**
     * Create a new notification instance.
     *
     * @param  int  $tierId
     * @return void
     */
    public function __construct($tierId)
    {
        $this->tierId = $tierId;
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
            ->line('Your tier has been upgraded.')
            ->line('You now have access to more features on the platform.')
            ->line('Thank you for using our platform!');
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
            'tier_id' => $this->tierId,
            'message' => 'Your tier has been upgraded.'
        ];
    }
}
