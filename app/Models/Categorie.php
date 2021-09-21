<?php

namespace App\Models;

use App\Models\Serie;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Categorie
 *
 * @property int $id
 * @property string $name 分類名
 * @property int $order 分類排序
 * @property int $pid 父ID
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read Article|null $article
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Categorie extends Model
{
    protected $guarded  = [];



    public function article()
    {
        return $this->hasMany(Article::class, 'categorie_id', 'id');
    }
    public function serie()
    {
        return $this->hasOne(Serie::class, 'categorie_id', 'id');
    }

    /**
     *  該類別文章的總數
     */
    public function getArticleTotleAttribute()
    {
        return $this->article->count();
    }

}
