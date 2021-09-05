<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\SerieHasArticle;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'result' => Serie::with(['article' => function ($query) {
                return  $query->with('articleDetil');
            }, 'Categorie'])->get()
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
    public function show(Serie $serie)
    {
        return response()->json([
            'result' => $serie
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
        SerieHasArticle::where('serie_id', $serie->id)->delete();
        foreach ($request['article'] as $key => $value) {
            $data = ['article_id' => $value, 'page' => $key];
            $serie->serieHasArticle()->create($data);
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
