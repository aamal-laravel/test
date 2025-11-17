<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'type',
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
