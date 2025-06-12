<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'contract_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
