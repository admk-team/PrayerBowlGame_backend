<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'count', 'last_opened_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
