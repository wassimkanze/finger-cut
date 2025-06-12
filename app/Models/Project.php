<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function employees()
    {
        return $this->belongsToMany(User::class);
    }

    public function planningSlots()
    {
        return $this->hasMany(\App\Models\PlanningSlot::class);
    }
}