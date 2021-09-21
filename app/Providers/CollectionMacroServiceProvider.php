<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Collection::macro('EXwhere', function ($key, $operator, $value = null) {
            $key   = $this->getArrayableItems($key);
            if (func_num_args() == 2) {
                $value = is_array($operator) ? head($operator) : $operator;
                $operator = '=';
            }
            return $this->filter(function ($item) use ($key, $operator, $value) {
                foreach ($key as $v) {
                    if (is_array($item) && array_key_exists($v, $item)) {
                        $select = $v;
                        break;
                    }
                }
                if (!isset($select)) {
                    return false;
                }
                $retrieved = data_get($item, $select);
                switch ($operator) {
                    default:
                    case '=':
                    case '==':
                        return $retrieved == $value;
                    case '!=':
                    case '<>':
                        return $retrieved != $value;
                    case '<':
                        return $retrieved < $value;
                    case '>':
                        return $retrieved > $value;
                    case '<=':
                        return $retrieved <= $value;
                    case '>=':
                        return $retrieved >= $value;
                    case '===':
                        return $retrieved === $value;
                    case '!==':
                        return $retrieved !== $value;
                }
            });
        });
        /**
         * 重寫 Appends 屬性
         */
        Collection::macro('setAppends', function ($attributes, $model = null) {
            return $this->map(function ($item) use ($attributes, $model) {
                if ($model) {
                    $item->getRelation($model)->setAppends($attributes);
                }
                return $item->setAppends($attributes);
            });
        });
    }
}
