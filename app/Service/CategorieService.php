<?php

namespace App\Service;

use App\Models\Categorie;
use App\Service\Traits\ORM;
use Illuminate\Support\Str;


class CategorieService
{
    use ORM;

    public function articlePaginate(Categorie $categorie, $pagination, $where = null, $order = null)
    {
        $article = $categorie->article()->with('articleDetil');
        if ($where) {
            foreach ($where as $key => $value) {
                $article->where(Str::snake($key), $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                $article->orderBy(Str::snake($key), $value);
            }
        }
        $article = $article->paginate($pagination['size'], ['*'], 'page', $pagination['page']);
        return $article;
    }
    public function seriePaginate(Categorie $categorie, $pagination, $where = null, $order = null)
    {
        $article = $categorie->serie()->with(['serieHasArticle']);
        if ($where) {
            foreach ($where as $key => $value) {
                $article->where(Str::snake($key), $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                $article->orderBy(Str::snake($key), $value);
            }
        }
        $seriePaginate = $article->paginate($pagination['size'], ['*'], 'page', $pagination['page']);
        return [
            'list'       => $seriePaginate->items(),
            'pagination' => [
                'page'  => $seriePaginate->currentPage(),
                'size'  => $pagination['size'],
                'total' => $seriePaginate->total(),
            ]
        ];
    }
}
