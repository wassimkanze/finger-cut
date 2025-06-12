<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningSlot extends Model
{
    protected $fillable = [
        'start_time',
        'date',
        'end_time',
        'location',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
