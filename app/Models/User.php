<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'country',
        'language',
        'password',
        'sub_id',
        'account_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // Define the relationship with notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function topwarrior()
    {
        return $this->hasOne(TopWarrior::class, 'topwarrior_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Register the deleting event to delete related notifications
        static::deleting(function ($user) {
            $user->notifications()->delete();
        });

        // Define a deleting event listener for deleting related testimonials
        // static::deleting(function ($user) {
        //     // Delete related testimonials when the user is deleted
        //     $user->testimonials()->delete();
        // });
    }

    // Define the relationship with testimonials
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    //user locale
    public function preferredLocale()
    {
        return $this->language;
    }
    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class);
    }
}
