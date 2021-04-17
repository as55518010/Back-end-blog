<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

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
            'data' => Serie::get()
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
            'data' => Serie::create($request->only(['categorie_id', 'article_id', 'name', 'description']))
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
            'data' => $serie
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
        if ($serie->update($request->only(['categorie_id', 'article_id', 'name', 'description']))) {
            return response()->json([
                'message' => '已成功更新類別區塊',
                'data'    => $serie
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
                'message' => '已成功刪除類別區塊',
                'data'    => $serie
            ]);
        }
    }
}
