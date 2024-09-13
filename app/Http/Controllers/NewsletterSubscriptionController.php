<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Subscribe to the newsletter.
     */
    public function subscribe(Request $request)
    {
        // Validate the email address
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the subscription
        NewsletterSubscription::create(['email' => $request->email]);

        return response()->json(['message' => 'Successfully subscribed to the newsletter']);
    }

    /**
     * Unsubscribe from the newsletter.
     */
    public function unsubscribe(Request $request)
    {
        $subscription = NewsletterSubscription::where('email', $request->email)->first();
        
        if ($subscription) {
            $subscription->update(['is_subscribed' => false]);
            return response()->json(['message' => 'Successfully unsubscribed']);
        }

        return response()->json(['message' => 'Email not found'], 404);
    }
}