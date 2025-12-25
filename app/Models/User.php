<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }

    /**
     * Required by laravel-notification-channels/fcm
     * Returns array of tokens for multicast sending
     */
    public function routeNotificationForFcm()
    {
        return $this->fcmTokens()->pluck('fcm_token')->toArray();
    }

    public function addFcmToken(string $token, string $platform, string $deviceName): FcmToken
    {
        // Check if exact combination exists
        $existing = $this->fcmTokens()
            ->where('fcm_token', $token)
            ->where('platform', $platform)
            ->where('device_name', $deviceName)
            ->first();

        if ($existing) {
            $existing->touch(); // Update timestamp
            return $existing;
        }

        // Create new token entry
        return $this->fcmTokens()->create([
            'fcm_token' => $token,
            'platform' => $platform,
            'device_name' => $deviceName,
        ]);
    }
}
