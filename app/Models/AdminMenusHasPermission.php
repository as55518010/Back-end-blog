<?php

namespace App\Models;

use App\Models\{AdminMenu, Permission};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{belongsTo, HasOne};


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
