<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'anonymized_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'anonymized_at' => 'datetime',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is employee
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employé';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active && !$this->anonymized_at;
    }

    /**
     * Check if user is anonymized
     */
    public function isAnonymized(): bool
    {
        return !is_null($this->anonymized_at);
    }

    /**
     * Anonymize user data (GDPR compliant)
     */
    public function anonymize(): void
    {
        $this->update([
            'name' => 'Utilisateur Anonymisé',
            'email' => 'anonyme_' . $this->id . '@deleted.local',
            'is_active' => false,
            'anonymized_at' => now(),
        ]);
    }

    /**
     * Get user role display name
     */
    public function getRoleDisplayName(): string
    {
        if ($this->isAnonymized()) {
            return 'Compte Désactivé';
        }
        return $this->role === 'admin' ? 'Administrateur' : 'Employé';
    }

    /**
     * Get user status display
     */
    public function getStatusDisplay(): string
    {
        if ($this->isAnonymized()) {
            return 'Anonymisé';
        }
        return $this->is_active ? 'Actif' : 'Inactif';
    }

    /**
     * Get the events assigned to this user
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user')
                    ->withPivot('role', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get upcoming events for this user
     */
    public function upcomingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user')
                    ->where('start_date', '>=', now()->toDateString())
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('start_date')
                    ->withPivot('role', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get user notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get unread notifications
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    /**
     * Get read notifications
     */
    public function readNotifications()
    {
        return $this->notifications()->read();
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }
}
