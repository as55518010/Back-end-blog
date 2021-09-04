<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
