<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\SerieHasArticle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Serie
 *
 * @property int $id
 * @property int $categorieId
 * @property string $name 系列名
 * @property string|null $description 系列描述
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $Article
 * @property-read int|null $articleCount
 * @property-read Categorie $categorie
 * @property-read \Illuminate\Database\Eloquent\Collection|SerieHasArticle[] $serieHasArticle
 * @property-read int|null $serieHasArticleCount
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Serie extends Model
{
    protected $guarded  = [];

    /**
     * 關聯 ArticleDetil Table
     */
    public function serieHasArticle()
    {
        return $this->hasMany(SerieHasArticle::class,'serie_id','id');
    }
    /**
     * 關聯 ArticleDetil Table
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id','id');
    }
    /**
     * 關聯 ArticleDetil Table
     */
    public function article()
    {
        return $this->belongsToMany(Article::class,SerieHasArticle::class)->withPivot('page');
    }
}
