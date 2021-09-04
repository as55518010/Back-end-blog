<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
