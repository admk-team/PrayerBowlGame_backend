<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'description',
        'type',
        'milestone_1',
        'milestone_2',
        'milestone_3',
    ];
}
