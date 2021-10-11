<?php

namespace App\Providers;

use Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
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
        // 基于关联关系排序实现
        Builder::macro(
            'orderByWith',
            function ($relation, $column, $direction = 'asc'): Builder {
                /** @var Builder $this */
                if (is_string($relation)) {
                    $relation = $this->getRelationWithoutConstraints($relation);
                }

                return $this->orderBy(
                    $relation->getRelationExistenceQuery(
                        $relation->getRelated()->newQueryWithoutRelationships(),
                        $this,
                        $column
                    ),
                    $direction
                );
            }
        );
    }
}
