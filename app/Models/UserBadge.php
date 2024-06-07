<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;
    protected $fillable = [
        'badge_id',
        'user_id',
        'achievement',
        'milestone',
        'completed_at1',
        'completed_at2',
        'completed_at3',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
