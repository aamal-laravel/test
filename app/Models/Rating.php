<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'provider_id',
        'tourist_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }
}
