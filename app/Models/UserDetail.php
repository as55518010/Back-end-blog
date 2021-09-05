<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\UserDetail
 *
 * @property int $id
 * @property int $userId
 * @property string|null $avatarPath
 * @property string|null $description
 * @property string|null $introduction
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read string $avatar
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereAvatarPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUserId($value)
 * @mixin \Eloquent
 */
class UserDetail extends Model
{
    protected $guarded  = [];

    protected $appends  = ['avatar'];

    /**
     * 解析頭像
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
