<?php

namespace App\Service;

use App\Models\Serie;
use App\Models\Article;
use App\Models\Categorie;
use App\Service\Traits\ORM;


class ArticleService
{
    use ORM;

    public function categoryArticlePaginate(Article $article, Categorie $categorie, $pagination)
    {
        $serieArticle = $categorie->article()->where('id', '>', $article->id);
        $paginateData = $this->paginateData($serieArticle, $pagination);
        return $paginateData;
    }
    public function seriesArticlePaginate(Article $article, Serie $serie, $pagination)
    {
        $serieArticle = $serie->article()->where('id', '>', $article->id);
        $paginateData = $this->paginateData($serieArticle, $pagination);
        return $paginateData;
    }
    public function seriesArticleData(Article $article, Serie $serie)
    {
        $article->serieLast = $serie->article()->where('id', '<', $article->id)->orderBy('id', 'desc')->with(['articleDetil'])->first();
        $article->serieNext = $serie->article()->where('id', '>', $article->id)->orderBy('id', 'asc')->with(['articleDetil'])->first();
        $article->seriesId = $serie->id;
        $article = $article->load(['articleDetil']);
        return $article;
    }
    public function seriePaginate(Article $article, $pagination, $where = null, $order = null)
    {
        $serie = $article->serie();
        return $this->paginateData($serie, $pagination, $where, $order);
    }
}
