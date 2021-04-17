<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Article::with(['articleDetil'])->get()
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
                    'article_id',
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
        return response()->json([
            'data' => $article->load(['articleDetil'])
        ]);
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
                'article_id',
                'tag',
                'description',
                'view',
                'recommend'
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
