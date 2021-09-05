<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use Illuminate\Database\Eloquent\Relations\{hasManyThrough, HasOne};


/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $twName 名稱
 * @property string $guardName
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\Models\AdminMenu|null $adminMenu
 * @property-read \App\Models\AdminMenusHasPermission|null $adminMenusHasPermission
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read int|null $permissionsCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $rolesCount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $usersCount
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereTwName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    /**
     * 菜單權限
     */
    public function adminMenu(): hasManyThrough
    {
        return $this->hasOneThrough(
            AdminMenu::class,
            AdminMenusHasPermission::class,
            'permission_id',
            'id',
            'id',
            'admin_menus_id'
        );
    }
    public function adminMenusHasPermission(): HasOne
    {
        return $this->HasOne(AdminMenusHasPermission::class, 'permission_id', 'id');
    }
}
