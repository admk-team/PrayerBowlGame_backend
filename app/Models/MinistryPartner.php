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
        'media_links',
        'media_icon',
        'email',
        'phone',
    ];
}
