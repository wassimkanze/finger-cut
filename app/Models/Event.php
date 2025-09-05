<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'street',
        'number',
        'postal_code',
        'city',
        'status',
        'color',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the users assigned to this event
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user')
                    ->withPivot('role', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get only active users assigned to this event
     */
    public function activeUsers()
    {
        return $this->belongsToMany(User::class, 'event_user')
                    ->where('is_active', true)
                    ->whereNull('anonymized_at')
                    ->withPivot('role', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get the status display name
     */
    public function getStatusDisplayName(): string
    {
        return match($this->status) {
            'planned' => 'Planifié',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            default => 'Inconnu'
        };
    }

    /**
     * Get the status color
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'planned' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Check if event is multi-day
     */
    public function isMultiDay(): bool
    {
        return $this->start_date->diffInDays($this->end_date) > 0;
    }

    /**
     * Get event duration in days
     */
    public function getDurationInDays(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Get formatted date range
     */
    public function getFormattedDateRange(): string
    {
        if ($this->start_date->isSameDay($this->end_date)) {
            return $this->start_date->format('d/m/Y');
        }
        
        return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
    }

    /**
     * Get formatted address
     */
    public function getFormattedAddress(): string
    {
        $parts = [];
        
        if ($this->location) {
            $parts[] = $this->location;
        }
        
        if ($this->number && $this->street) {
            $parts[] = $this->number . ' ' . $this->street;
        } elseif ($this->street) {
            $parts[] = $this->street;
        }
        
        if ($this->postal_code && $this->city) {
            $parts[] = $this->postal_code . ' ' . $this->city;
        } elseif ($this->city) {
            $parts[] = $this->city;
        }
        
        return implode(', ', $parts);
    }
}
