<?php

namespace App\Models;

use App\Models\ArticleDetil;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded  = [];

    /**
     * 關聯 ArticleDetil Table
     */
    public function articleDetil()
    {
        return $this->hasOne(ArticleDetil::class,'article_id','id');
    }

    /**
     *  該文章的上一筆
     */
    public function getLastAttribute()
    {
        return $this->where([
            ['id','<',$this->id]
        ])->orderBy('id', 'desc')->first();
    }
    /**
     *  該文章的下一筆
     */
    public function getNextAttribute()
    {
        return $this->where([
            ['id','>',$this->id]
        ])->orderBy('id', 'asc')->first();
    }
}
