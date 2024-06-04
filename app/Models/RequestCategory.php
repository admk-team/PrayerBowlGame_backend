<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image'
    ];
    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class, 'cat_id');
    }
}
