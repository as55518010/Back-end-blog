<?php

namespace App\Models;

use App\Models\Categorie;
use App\Models\ArticleDetil;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $categorieId
 * @property string $title 文章標題
 * @property string $content 文章內容
 * @property string $author 文章作者
 * @property string|null $thumb 文章縮略圖
 * @property string|null $deletedAt
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read ArticleDetil|null $articleDetil
 * @property-read mixed $last
 * @property-read mixed $next
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $guarded  = [];

    /**
     * 關聯 ArticleDetil Table
     */
    public function articleDetil()
    {
        return $this->hasOne(ArticleDetil::class, 'article_id', 'id');
    }

    /**
     * 關聯 Categorie Table
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    /**
     * 關聯 serieHasArticle Table
     */
    public function serieHasArticle()
    {
        return $this->hasMany(SerieHasArticle::class,'article_id','id');
    }

    /**
     *  該文章的上一筆
     */
    public function getLastAttribute()
    {
        return $this->where([
            ['id', '<', $this->id]
        ])->orderBy('id', 'desc')->first();
    }
    /**
     *  該文章的下一筆
     */
    public function getNextAttribute()
    {
        return $this->where([
            ['id', '>', $this->id]
        ])->orderBy('id', 'asc')->first();
    }
    /**
     *  該類別文章的上一筆
     */
    public function getCategorieLastAttribute()
    {
        return $this->where([
            ['id', '<', $this->id],
            ['categorie_id', '=', $this->categorie_id],
        ])->orderBy('id', 'desc')->first();
    }
    /**
     *  該類別文章的下一筆
     */
    public function getCategorieNextAttribute()
    {
        return $this->where([
            ['id', '>', $this->id],
            ['categorie_id', '=', $this->categorie_id],
        ])->orderBy('id', 'asc')->first();
    }
}
