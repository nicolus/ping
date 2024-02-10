<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmailInterface
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, MustVerifyEmail, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function probes(): HasMany
    {
        return $this->hasMany(Probe::class);
    }

    /**
     * Route notifications for the Vonage channel.
     *
     * @param Notification $notification
     * @return ?string
     */
    public function routeNotificationForVonage(Notification $notification): ?string
    {
        return $this->phone_number;
    }

    /**
     * Route notifications for the Firebase Cloud Messenging channel.
     * The fcm_token is set by the mobile app when the user first connects.
     */
    public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }
}
