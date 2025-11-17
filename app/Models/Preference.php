<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public function tourists()
    {
        return $this->belongsToMany(Tourist::class, 'preference_tourist')
            ->withPivot('type')
            ->withTimestamps();
    }
}
