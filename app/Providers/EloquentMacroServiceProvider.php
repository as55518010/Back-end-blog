<?php

namespace App\Providers;

use Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;

class EloquentMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 將資料格式化成樹形結構
         */
        Collection::macro('getTree', function ($sonName = 'son', $sonTableName = 'pid') {
            return Arr::getTree($this->keyBy('id')->toArray(), $sonName, $sonTableName);
        });
    }
}
