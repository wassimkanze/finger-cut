<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'project_type',
        'message',
        'read',
        'archived',
    ];

    protected $casts = [
        'read' => 'boolean',
        'archived' => 'boolean',
    ];

    /**
     * Scope pour les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope pour les messages lus
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope pour les messages archivés
     */
    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    /**
     * Scope pour les messages non archivés (actifs)
     */
    public function scopeActive($query)
    {
        return $query->where('archived', false);
    }

    /**
     * Marquer le message comme lu
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }

    /**
     * Marquer le message comme non lu
     */
    public function markAsUnread()
    {
        $this->update(['read' => false]);
    }

    /**
     * Archiver le message
     */
    public function archive()
    {
        $this->update(['archived' => true]);
    }

    /**
     * Désarchiver le message
     */
    public function unarchive()
    {
        $this->update(['archived' => false]);
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}