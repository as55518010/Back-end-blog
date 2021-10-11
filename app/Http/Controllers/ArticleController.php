<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Support\Str;
use App\Models\ArticleDetil;
use Illuminate\Http\Request;
use App\Service\ArticleService;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = json_decode($request['pagination'], true);
        $where      = json_decode($request['where'], true);
        $order      = json_decode($request['order'], true);
        $query      = Article::with(['articleDetil']);

        if ($where) {
            foreach ($where as $key => $value) {
                $query->where(Str::snake($key), $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                if (Str::snake($key) === 'article_detils') {
                    foreach ($value as $key1 => $value1) {
                        $query->orderByWith('articleDetil', $key1, $value1);
                    }
                } else {
                    $query->orderBy(Str::snake($key), $value);
                }
            }
        }
        $res = $query->paginate($pagination['size'], ['*'], 'page', $pagination['page']);
        return response()->json([
            'list'      => $res->items(),
            'pagination' => [
                'page'  => $res->currentPage(),
                'size'  => $pagination['size'],
                'total' => $res->total(),
            ]
        ]);
    }
    /**
     * 文章總數
     */
    public function articleCount()
    {
        return response()->json([
            'message' => '已成功獲取文章總數量',
            'result'  => Article::count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json([
            'data' => tap(Article::create($request->only([
                'categorie_id',
                'title',
                'content',
                'author',
                'thumb'
            ])), function ($articleModel) use ($request) {
                $articleModel->articleDetil()->create($request->only([
                    'tag',
                    'description',
                    'view',
                    'recommend'
                ]));
            })->load(['articleDetil'])
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if (!isset($response['articleData'])) {
            $response['articleData']  = $article->append(['last', 'next'])->load(['articleDetil']);
        }
        return response()->json($response);
    }
    /**
     * 系列文章
     */
    public function showSeriesArticle(Request $request, Article $article, Serie $serie, ArticleService $articleService)
    {
        if ($request->has('series')) {
            $series              = json_decode($request['series'], true);
            $response['seriesArticleData'] = $articleService->seriesArticlePaginate($article, $serie, $series['pagination']);
            $response['articleData']       = $articleService->seriesArticleData($article, $serie);
            $response['series']            = $serie->load(['serieHasArticle']);
        }
        return response()->json($response);
    }
    /**
     * 類別文章
     */
    public function showCategoryArticle(Request $request, Article $article, Categorie $categorie, ArticleService $articleService)
    {
        if ($request->has('category')) {
            $category            = json_decode($request['category'], true);
            $response['categoryArticleData'] = $articleService->categoryArticlePaginate($article, $categorie, $category['pagination']);
            $response['articleData']       = $article->append(['categorieLast', 'categorieNext'])->load(['articleDetil']);
            $response['categorie']         = $categorie->append(['articleTotle']);
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        DB::transaction(function () use ($request, $article) {
            $article->update($request->only([
                'categorie_id',
                'title',
                'content',
                'author',
                'thumb'
            ]));
            $article->articleDetil()->update($request->only([
                'tag',
                'description',
                'recommend',
                'view'
            ]));
        });
        return response()->json([
            'message' => '已成功更新文章',
            'data'    => $article
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if ($article->delete()) {
            return response()->json([
                'message' => '已成功刪除文章',
                'data'    => $article
            ]);
        }
    }
}
