<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:newsletter_subscriptions']);

        NewsletterSubscription::create([
            'email' => $request->email,
            'is_subscribed' => true,
        ]);

        return response()->json(['message' => 'Subscribed successfully!']);
    }

    public function unsubscribe(Request $request)
    {
        $subscription = NewsletterSubscription::where('email', $request->email)->first();

        if ($subscription) {
            $subscription->update(['is_subscribed' => false]);
            return response()->json(['message' => 'Unsubscribed successfully!']);
        }

        return response()->json(['message' => 'Email not found!'], 404);
    }

    public function sendNewsletter(Request $request)
    {
        $subscribers = NewsletterSubscription::where('is_subscribed', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterMail($request->content));
        }

        return response()->json(['message' => 'Newsletter sent to all subscribers!']);
    }
}
