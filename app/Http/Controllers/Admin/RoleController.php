<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => '角色獲取成功',
            'result'  => Role::with('permissions')->get()
        ]);
    }

    public function page(Request $request)
    {
        $query = Role::with('permissions');
        if ($request->filled(['order', 'sort'])) {
            $query = $query->orderBy($request['order'], $request['sort']);
        }
        $res = $query->paginate($request['size'], ['*'], 'page', $request['page']);
        return response()->json([
            'message'    => '角色獲取成功',
            'list'      => $res->items(),
            'pagination' => [
                'page'  => $res->currentPage(),
                'size'  => $request['size'],
                'total' => $res->total(),
            ]
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json([
            'message' => '權限獲取成功',
            'result' => $role->load('permissions')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        return response()->json([
            'message' => '權限獲取成功',
            'result' => $role->load('permissions')->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return response()->json([
                'message' => '已成功刪除菜單',
                'result'    => $role
            ]);
        }
    }
}
