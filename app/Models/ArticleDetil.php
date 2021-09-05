<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleDetil
 *
 * @property int $id
 * @property int $articleId
 * @property array|null $tag 文章標籤
 * @property string|null $description 文章描述
 * @property int $view 文章瀏覽次數
 * @property int $recommend 文章推薦狀態: 0:未推薦 1:加入推薦
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleDetil whereView($value)
 * @mixin \Eloquent
 */
class ArticleDetil extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tag' => 'array',
    ];

    protected $guarded  = [];
}
