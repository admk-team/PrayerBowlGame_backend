<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderNotification extends Model
{
    use HasFactory;

    const DURATION_DAY = 'day';
    const DURATION_WEEK = 'week';
    const DURATION_MONTH = 'month';
    const DURATION_YEAR = 'year';

    protected $fillable = ['user_id', 'type', 'start_datetime', 'duration'];

    protected $casts = [
        'start_datetime' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

