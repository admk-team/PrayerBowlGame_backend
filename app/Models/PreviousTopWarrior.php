<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousTopWarrior extends Model
{
    use HasFactory;
    protected $fillable = ['warriors'];

    protected $casts = [
        'warriors' => 'array',
    ];
}
