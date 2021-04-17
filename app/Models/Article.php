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
}
