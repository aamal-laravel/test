<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
    ];

    public function tourists()
    {
        return $this->belongsToMany(Tourist::class, 'notification_user')
            ->withPivot('status')
            ->withTimestamps();
    }
}
