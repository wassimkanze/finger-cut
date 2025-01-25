<?php

namespace App\Models;

use Database\Factories\RoleTache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function roles()
    {
        return $this->hasMany(RoleTache::class);
    }
}
