<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'email',
        'role',
        'used',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user who created this invitation
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate a unique invitation code
     */
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Create a new invitation code
     */
    public static function createInvitation($email = null, $role = 'employé', $expiresInDays = 30)
    {
        return self::create([
            'code' => self::generateCode(),
            'email' => $email,
            'role' => $role,
            'created_by' => auth()->id(),
            'expires_at' => now()->addDays((int)$expiresInDays),
        ]);
    }

    /**
     * Check if invitation is valid
     */
    public function isValid(): bool
    {
        return !$this->used && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Mark invitation as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Scope for valid invitations
     */
    public function scopeValid($query)
    {
        return $query->where('used', false)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for expired invitations
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }
}