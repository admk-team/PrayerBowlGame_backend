<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Supporters extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'email',
        'payment_id',
        'amount',
        'status',
        'date'
    ];
}
