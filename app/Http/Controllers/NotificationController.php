<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Get user notifications
     */
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(10);
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotificationsCount()
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'unread_count' => auth()->user()->unreadNotificationsCount()
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update([
            'read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'unread_count' => auth()->user()->unreadNotificationsCount()
        ]);
    }

    /**
     * Get unread notifications count (for AJAX updates)
     */
    public function unreadCount()
    {
        return response()->json([
            'unread_count' => auth()->user()->unreadNotificationsCount()
        ]);
    }
}