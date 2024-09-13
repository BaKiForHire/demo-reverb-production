<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewAuctionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $auction;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
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
            ->line('A new auction has been created.')
            ->action('View Auction', url('/auctions/' . $this->auction->id))
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
            'auction_id' => $this->auction->id,
            'title' => $this->auction->title,
            'message' => 'A new auction has been created.'
        ];
    }
}
