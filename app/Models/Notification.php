<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Create a notification for a user
     */
    public static function createForUser($userId, $type, $title, $message, $data = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Get notification type display name
     */
    public function getTypeDisplayName(): string
    {
        return match($this->type) {
            'event_assigned' => 'Événement assigné',
            'event_updated' => 'Événement modifié',
            'event_cancelled' => 'Événement annulé',
            'general' => 'Général',
            default => 'Notification'
        };
    }

    /**
     * Get notification type color
     */
    public function getTypeColor(): string
    {
        return match($this->type) {
            'event_assigned' => 'bg-blue-100 text-blue-800',
            'event_updated' => 'bg-yellow-100 text-yellow-800',
            'event_cancelled' => 'bg-red-100 text-red-800',
            'general' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get notification icon
     */
    public function getIcon(): string
    {
        return match($this->type) {
            'event_assigned' => 'fas fa-calendar-plus',
            'event_updated' => 'fas fa-calendar-check',
            'event_cancelled' => 'fas fa-calendar-times',
            'general' => 'fas fa-bell',
            default => 'fas fa-bell'
        };
    }
}