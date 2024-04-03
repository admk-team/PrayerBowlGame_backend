<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryPartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'order',
        'link',
        'email',
        'phone',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'whatsApp',
        'tik_tok',
        'linked_in',
        'christian_circle',
    ];
}
