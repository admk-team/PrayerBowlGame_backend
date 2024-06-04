<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderNotification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'start_datetime', 'duration'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
