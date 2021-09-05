<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Models\{AdminMenusHasPermission,AdminMenuMeta};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, hasMany};

/**
 * App\Models\AdminMenu
 *
 * @property int $id
 * @property int $pid 父菜單ID
 * @property string $name 名稱
 * @property string|null $path 路由地址
 * @property string|null $component 組件地址
 * @property string|null $redirect 重定向
 * @property int $order 排序
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|AdminMenusHasPermission[] $adminMenusHasPermission
 * @property-read int|null $adminMenusHasPermissionCount
 * @property-read AdminMenuMeta|null $meta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permission
 * @property-read int|null $permissionCount
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereComponent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
