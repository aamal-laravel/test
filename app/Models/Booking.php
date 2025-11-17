<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'quantity',
        'price',
        'booking_details',
        'booking_response',
        'note',
        'status',
        'evaluate',
        'service_id',
        'tourist_id',
    ];

    protected $casts = [
        'booking_details' => 'array',
        'booking_response' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }
}
