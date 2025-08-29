<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'destination',
        'start_date',
        'end_date',
        'transport',
        'accommodation',
        'budget',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
