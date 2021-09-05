<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminMenuMeta
 *
 * @property int $id
 * @property int $adminMenusId 關聯 admin_menus
 * @property string $title 路由title
 * @property int $ignoreKeepAlive 是否忽略KeepAlive緩存
 * @property int $affix 是否固定標籤
 * @property string|null $icon 圖標
 * @property string|null $frameSrc 內嵌iframe的地址
 * @property string|null $transitionName 指定該路由切換的動畫名
 * @property int $hideBreadcrumb 隱藏該路由在麵包屑上面的顯示
 * @property int $carryParam 如果該路由會攜帶參數，且需要在tab頁上面顯示。則需要設置為true
 * @property int $hideChildrenInMenu 隱藏所有子菜單
 * @property string|null $currentActiveMenu 當前激活的菜單。用於配置詳情頁時左側激活的菜單路徑
 * @property int $hideTab 當前路由不再標籤頁顯示
 * @property int $hideMenu 當前路由不再菜單顯示
 * @property int $ignoreRoute 忽略路由
 * @property int $hidePathForChildren 是否在子級菜單的完整path中忽略本級path
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereAdminMenusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereAffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereCarryParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereCurrentActiveMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereFrameSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereHideBreadcrumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereHideChildrenInMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereHideMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereHidePathForChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereHideTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereIgnoreKeepAlive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereIgnoreRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereTransitionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminMenuMeta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminMenuMeta extends Model
{
    protected $guarded  = [];

}
