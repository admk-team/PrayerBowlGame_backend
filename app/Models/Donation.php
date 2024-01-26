<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'name_on_card',
        'expiry_date',
        'cvv',
        'supporter_name',
        'country',
        'donation_amount',
        'donation_type',
    ];

}
