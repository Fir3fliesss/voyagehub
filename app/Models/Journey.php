<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'travel_request_id',
        'title',
        'destination',
        'start_date',
        'end_date',
        'transport',
        'accommodation',
        'budget',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'budget' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travelRequest()
    {
        return $this->belongsTo(TravelRequest::class);
    }
}
