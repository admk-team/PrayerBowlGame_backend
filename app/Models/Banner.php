<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'banner',
        'content',
        'start_date',
        'end_date',
        'views',
        'clicks',
        'max_views',
        'max_clicks',
    ];
}
