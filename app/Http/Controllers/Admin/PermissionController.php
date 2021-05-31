<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => '權限獲取成功',
            'result'    => Permission::get()
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
        $this->validate($request, [
            'name'   => 'required|unique:permissions,name',
            'guard_name' => 'string',
        ]);
        $Permission = Permission::create($request->only([
            'name', 'guard_name'
        ]));
        return response()->json([
            'message' => '創建權限成功',
            'result'  => $Permission
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return response()->json([
            'message' => '權限獲取成功',
            'result' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name'       => 'required|unique:permissions,name',
            'guard_name' => 'string',
        ]);
        $permission->update($request->only([
            'name', 'guard_name'
        ]));
        return response()->json([
            'message' => '已成功更新菜單',
            'result'    => $permission
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if ($permission->delete()) {
            return response()->json([
                'message' => '已成功刪除菜單',
                'result'    => $permission
            ]);
        }
    }
}
