<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use Illuminate\Console\Command;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterNotification;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletters to all subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscribers = NewsletterSubscription::where('is_subscribed', true)->get();

        foreach ($subscribers as $subscriber) {
            // Replace the content with your actual newsletter content
            $content = "Here is the latest news from our platform!";
            Mail::to($subscriber->email)->queue(new NewsletterMail($content));
        }

        $this->info('Newsletter sent to all subscribers. Count: ' . $subscribers->count());
        return Command::SUCCESS;
    }
}
