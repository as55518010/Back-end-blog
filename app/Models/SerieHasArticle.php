<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SerieHasArticle
 *
 * @property int $serieId
 * @property int $articleId
 * @property int $page 分頁
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerieHasArticle whereSerieId($value)
 * @mixin \Eloquent
 */
class SerieHasArticle extends Model
{
    public $timestamps = false;
    protected $guarded  = [];
}
