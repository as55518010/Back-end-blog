<?php

namespace App\Providers;

use Arr;
use Illuminate\Support\ServiceProvider;

class ArrMacroServiceProvider extends ServiceProvider
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
        Arr::macro('getTree', function ($items, $sonName = 'son', $sonTableName = 'pid') {
            $tree = array(); //格式化好的樹
            foreach ($items as $item) {
                if (isset($items[$item[$sonTableName]]))
                    $items[$item[$sonTableName]][$sonName][] = &$items[$item['id']];

                else

                    $tree[] = &$items[$item['id']];
            }
            return $tree;
        });
    }
}
