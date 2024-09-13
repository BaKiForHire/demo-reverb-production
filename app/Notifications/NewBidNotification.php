<?php

namespace App\Notifications;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewBidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $bid;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Bid  $bid
     * @return void
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->line('A new bid has been placed on an auction you are watching.')
            ->line('Bid amount: $' . number_format($this->bid->amount, 2))
            ->action('View Auction', url('/auctions/' . $this->bid->auction_id))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'bid' => $this->bid,
            'message' => 'A new bid has been placed on an auction you are watching.'
        ]);
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
            'auction_id' => $this->bid->auction_id,
            'amount' => $this->bid->amount,
            'message' => 'A new bid has been placed on an auction.'
        ];
    }
}
