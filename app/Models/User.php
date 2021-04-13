<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guarded  = [];

    protected $appends  = ['avatar'];

    protected $hidden = [
        'password',
        'remember_token',
        'avatar_path'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 获取用户名
     *
     * @param  string  $value
     * @return string
     */
    public function getAvatarAttribute()
    {
        return [
            'path' => $this->avatar_path,
            'url'  => Storage::disk('public')->url($this->avatar_path)
        ];
    }
}
