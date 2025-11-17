<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'DOB',
        'gender',
        'user_id',
        'country_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'preference_tourist')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('status')
            ->withTimestamps();
    }
}
