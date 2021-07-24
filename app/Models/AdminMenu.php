<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Models\{AdminMenusHasPermission,AdminMenuMeta};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, hasMany};

class AdminMenu extends Model
{
    protected $guarded  = [];

    /**
     * 菜單權限
     */
    public function permission(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.admin_menus_has_permissions'),
            'admin_menus_id',
            'permission_id'
        )->withPivot(['name']);
    }
    public function meta()
    {
        return $this->hasOne(AdminMenuMeta::class,'admin_menus_id','id');
    }
    public function adminMenusHasPermission(): hasMany
    {
        return $this->hasMany(AdminMenusHasPermission::class, 'admin_menus_id', 'id');
    }

    public function father(...$exclude)
    {
        if ($this->pid == 0 ||  in_array($this->pid,$exclude)) {
            return $this->with('meta')->get();
        }
        return $this->with('meta')->get()->merge($this->find($this->pid)->father(...$exclude));
    }
}
