<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeData extends Model
{
    use HasFactory;
    protected $table = "stripe";

    protected $fillable = ['name', 'card_no', 'cvc', 'expiration_month', 'expiration_year'];
}
