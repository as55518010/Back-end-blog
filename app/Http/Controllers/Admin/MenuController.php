<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'result'    => AdminMenu::orderBy('sort')->get()
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
                'name', 'url', 'sort', 'icon', 'keep_alive', 'pid'
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
            'name', 'url', 'sort', 'icon', 'keep_alive', 'pid'
        ]), fn ($val) => !empty($val)))) {
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
    public function menuSelf()
    {
        $selfPermissions =  Auth::user()->getAllPermissions()->pluck('name')->groupBy(function ($item, $key) {
            return Str::beforeLast($item, '-');
        })->map(fn ($item) => $item->map(fn ($val) => Str::afterLast($val, '-')));
        $selfPermissionsRoute = AdminMenu::whereIn('url', $selfPermissions->keys())->orderBy('sort')->get()->map(fn ($item) => $item->setAttribute('permission', $selfPermissions[$item->url]))->toArray();

        return response()->json([
            'message' => '獲取個人後台菜單成功',
            'result'    => $selfPermissionsRoute
        ]);
    }
}
