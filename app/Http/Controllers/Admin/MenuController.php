<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => '菜單獲取成功',
            'result'    => Arr::genTree(AdminMenu::with('meta')->orderBy('order')->get()->keyBy('id')->toArray(), 'children')
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
            'message' => '創建菜單成功',
            'result' => AdminMenu::create(array_filter($request->only([
                'pid', 'name', 'path', 'component', 'redirect', 'order'
            ]), fn ($val) => !empty($val)))
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(AdminMenu $menu)
    {
        return response()->json([
            'message' => '菜單獲取成功',
            'result' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminMenu $menu)
    {
        if ($menu->update(array_filter($request->only([
            'pid', 'name', 'path', 'component', 'redirect', 'order'
        ]), fn ($val) =>  $val !== null && $val !== ''))) {
            return response()->json([
                'message' => '已成功更新菜單',
                'result'    => $menu
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminMenu $menu)
    {
        if ($menu->delete()) {
            return response()->json([
                'message' => '已成功刪除菜單',
                'result'    => $menu
            ]);
        }
    }
}
