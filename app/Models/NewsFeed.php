<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFeed extends Model
{
    protected $guarded  = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'array',
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
