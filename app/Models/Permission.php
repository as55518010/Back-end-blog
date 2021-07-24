<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use Illuminate\Database\Eloquent\Relations\{hasManyThrough, HasOne};


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
