<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_type',
        'message',
        'user_id',
        'cat_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function requestcategory()
    {
        return $this->belongsTo(RequestCategory::class, 'cat_id');
    }
}
