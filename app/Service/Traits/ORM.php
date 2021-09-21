<?php

namespace App\Service\Traits;

use Illuminate\Support\Str;



trait ORM
{
    function paginateData($Model, $pagination, $where = null, $order = null)
    {
        if ($where) {
            foreach ($where as $key => $value) {
                $Model->where(Str::snake($key), $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                $Model->orderBy(Str::snake($key), $value);
            }
        }
        $Paginate = $Model->paginate($pagination['size'], ['*'], 'page', $pagination['page']);
        return [
            'list'       => $Paginate->items(),
            'pagination' => [
                'page'  => $Paginate->currentPage(),
                'size'  => $pagination['size'],
                'total' => $Paginate->total(),
            ]
        ];
    }
}
