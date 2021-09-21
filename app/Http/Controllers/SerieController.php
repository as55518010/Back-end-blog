<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SerieHasArticle;

class SerieController extends Controller
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
        if ($request->has(['pagination'])) {
            $Serie = Serie::with(['categorie','article'=>function($query){
                return $query->with('articleDetil');
            }]);
            if ($where) {
                foreach ($where as $key => $value) {
                    $Serie->where(Str::snake($key), $value);
                }
            }
            if ($order) {
                foreach ($order as $key => $value) {
                    $Serie->orderBy(Str::snake($key), $value);
                }
            }
            $Serie = $Serie->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            return response()->json([
                'list'       => $Serie->items(),
                'pagination' => [
                    'page'  => $Serie->currentPage(),
                    'size'  => $pagination['size'],
                    'total' => $Serie->total(),
                ]
            ]);
        }
        return ['result'=> Serie::get()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = 0;
        return response()->json([
            'result' => Serie::create($request->only(['categorie_id', 'name', 'description']))->serieHasArticle()->createMany(array_map(function ($value) use (&$page) {
                return ['article_id' => $value, 'page' => $page++];
            }, $request['article']))
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Serie $serie)
    {
        $pagination = json_decode($request['pagination'], true);
        $where      = json_decode($request['where'], true);
        $order      = json_decode($request['order'], true);

        $article = $serie->article()->with(['articleDetil']);
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

        return response()->json([
            'serieData'      => $serie->load(['serieHasArticle']),
            'article' => [
                'list'       => $article->items(),
                'pagination' => [
                    'page'  => $article->currentPage(),
                    'size'  => $pagination['size'],
                    'total' => $article->total(),
                ]
            ],
            'article' => [
                'list'       => $article->items(),
                'pagination' => [
                    'page'  => $article->currentPage(),
                    'size'  => $pagination['size'],
                    'total' => $article->total(),
                ]
            ]
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serie $serie)
    {
        if ($request->has('article')) {
            SerieHasArticle::where('serie_id', $serie->id)->delete();
            foreach ($request['article'] as $key => $value) {
                $data = ['article_id' => $value, 'page' => $key];
                $serie->serieHasArticle()->create($data);
            }
        }
        if ($serie->update($request->only(['categorie_id', 'name', 'description']))) {
            return response()->json([
                'message' => '已成功更新系列區塊',
                'result'    => $serie
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie)
    {
        if ($serie->delete()) {
            return response()->json([
                'message' => '已成功刪除系列區塊',
                'result'    => $serie
            ]);
        }
    }
}
