<?php

namespace App\Models;

use App\Models\UserDetail;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject
{
    use HasRoles;

    protected $guarded  = [];

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

    public function getAllAdminMenu(): Collection
    {
        $admin_menus_id =  $this->getAdminMenusHasPermission()->keys();
        return AdminMenu::whereIn('id', $admin_menus_id)->get()->reduce(function ($even, $odd) {
            if (empty($even)) {
                return $odd->father();
            }
            return $even->merge($odd->father(...$even->pluck('id')->toArray()));
        })->sort()->values();
    }
    public function getAdminMenusHasPermission(): Collection
    {
        /** @var Collection $permissions */
        $permissions = $this->getAllPermissions();
        return  $permissions->map(function ($permission) {
            return $permission->adminMenusHasPermission;
        })->groupBy('admin_menus_id');
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }
}
