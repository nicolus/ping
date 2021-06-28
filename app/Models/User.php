<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmailInterface
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, MustVerifyEmail, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function urls(): HasMany
    {
        return $this->hasMany(Url::class);
    }

    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed = true;
            $this->save();
        }

        return $codeIsValid;
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @param Notification $notification
     * @return ?string
     */
    public function routeNotificationForNexmo(Notification $notification): ?string
    {
        return $this->phone_number ?? false;
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
