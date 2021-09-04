<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $guarded  = [];



    public function article()
    {
        return $this->hasOne(Article::class, 'categorie_id', 'id');
    }
}
