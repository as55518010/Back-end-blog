<?php

namespace App\Models;

use App\Models\{AdminMenu, Permission};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{belongsTo, HasOne};


/**
 * App\Models\AdminMenusHasPermission
 *
 * @property int $adminMenusId
 * @property int $permissionId
 * @property-read Permission $Permission
 * @property-read AdminMenu $adminMenu
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenusHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenusHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenusHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenusHasPermission whereAdminMenusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenusHasPermission wherePermissionId($value)
 * @mixin \Eloquent
 */
class AdminMenusHasPermission extends Model
{
    /**
     * 菜單權限
     */
    public function adminMenu(): belongsTo
    {
        return $this->belongsTo(AdminMenu::class, 'admin_menus_id', 'id');
    }
    /**
     * 菜單權限
     */
    public function Permission(): belongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
