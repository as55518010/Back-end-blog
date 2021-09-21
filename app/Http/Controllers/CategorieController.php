<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Service\CategorieService;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'result' => Categorie::get()->getTree('children')
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
            'result' => Categorie::create($request->only(['name', 'order', 'pid']))
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Categorie $categorie, CategorieService $categorieService)
    {
        $response = ['categoryData'      => $categorie];

        if ($request->has('article')) {
            ['pagination' => $articlePagination, 'where' => $articleWhere] = json_decode($request['article'], true);
            $articlePaginate = $categorieService->articlePaginate($categorie, $articlePagination, $articleWhere);
            $response += [
                'article' => [
                    'list'       => $articlePaginate->items(),
                    'pagination' => [
                        'page'  => $articlePaginate->currentPage(),
                        'size'  => $articlePagination['size'],
                        'total' => $articlePaginate->total(),
                    ]
                ]
            ];
            if ($request->has('serie')) {
                ['pagination' => $seriePagination, 'where' => $serieWhere] = json_decode($request['serie'], true);
                $seriePaginate = $categorieService->seriePaginate($categorie, $seriePagination, $serieWhere);
                $response += [
                    'serie' => $seriePaginate
                ];
            }
        }
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        if ($categorie->update($request->only(['name', 'order', 'pid']))) {
            return response()->json([
                'message' => '已成功更新類別區塊',
                'result'    => $categorie
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        if ($categorie->delete()) {
            return response()->json([
                'message' => '已成功刪除類別區塊',
                'result'    => $categorie
            ]);
        }
    }
}
