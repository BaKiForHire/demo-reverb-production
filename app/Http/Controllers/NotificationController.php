<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing user notifications.
 * Handles listing notifications and marking them as read.
 */
class NotificationController extends Controller
{
    /**
     * List all unread notifications for the current user.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch unread notifications
        $notifications = $user->notifications->whereNull('read_at')->get();

        return response()->json($notifications);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    /**
     * Display and manage user notification settings.
     */
    public function settings()
    {
        // Logic to display and manage notification settings.
        return response()->json(['message' => 'Notification settings page.']);
    }
}
