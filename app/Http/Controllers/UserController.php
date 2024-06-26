<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;

class UserController extends Controller
{

    /**
     * 通過給定憑據獲取JWT
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::attempt($request->only(['email', 'password']))) {
            if (!$token = Auth::attempt($request->only(['name', 'password']))) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }
        return response()->json([
            'message' => '登入成功',
            'result'    => $this->respondWithToken($token)
        ]);
    }

    /**
     * 用戶註冊API
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create(array_merge($request->only(['name', 'email']), [
                'password' => bcrypt($request->input('password'))
            ]));
            if ($user) {
                $token = Auth::login($user);
                return response()->json(['message' => '成功註冊', 'result' => $this->respondWithToken($token)], 201);
            }
        } catch (QueryException $e) {
            report($e);
        }
        return response()->json(['message' => '註冊異常'], 500);
    }

    /**
     * 獲取經過身份驗證的用戶
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function information()
    {
        $expansion = [
            'roles' => ['admin'],
            'ability' => ['READ', 'WRITE', 'DELETE'],
            'username' => 'admin',
        ];
        return response()->json([
            'message' => '獲取用戶資訊成功',
            'result'    => array_merge($expansion, Auth::user()->load('detail')->toArray())
        ]);
    }

    /**
     * 記錄用戶（無效令牌）
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => '成功退出']);
    }

    /**
     * 刷新令牌
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'message' => '刷新令牌成功',
            'result'    => $this->respondWithToken(Auth::refresh())
        ]);
    }

    /**
     * 獲取令牌數組結構
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'token'  => $token,
            'expire' => Auth::factory()->getTTL() * 60,
        ];
    }

    /**
     * 修改個人專區
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        try {
            if ($request->hasAny(['name', 'email', 'password'])) {
                $updateData = array_filter([
                    'name'     => $request['name'] ?? '',
                    'email'    => $request['email'] ?? '',
                    'password' => isset($request['password']) ? bcrypt($request['password']) : null,
                ]);
                Auth::user()->update($updateData);
            }
            if ($request->hasAny(['avatar_path', 'description', 'introduction', 'contact_github', 'contact_email'])) {
                // dd(Auth::user()->detail()->update($request->only(['avatar_path', 'description', 'introduction', 'contact_github', 'contact_email'])));
                Auth::user()->detail()->update($request->only(['avatar_path', 'description', 'introduction', 'contact_github', 'contact_email']));
            }
            return response()->json(['message' => '個人專區更新成功', 'result' => Auth::user()], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => '個人專區更新失敗'], 404);
        }
    }

    /**
     * 上傳頭像
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $width = 75, $height = 75)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');
            if ($path) {
                Image::make('storage/' . $path)
                    ->resize($width, $height)->save();
                $updateData =  ['avatar_path' => $path];

                if (Auth::user()->update($updateData)) {
                    return response()->json(['message' => '上傳頭像成功', 'result' => Auth::user()], 201);
                }
            }
        }
        return response()->json(['message' => '上傳頭像失敗'], 500);
    }
    public function menu()
    {
        return response()->json([
            'message' => '獲取個人後台菜單成功',
            'result'    => Arr::getTree(Auth::user()->getAllAdminMenu()->keyBy('id')->toArray(), 'children')
        ]);
    }
    public function Permissions()
    {
        return response()->json([
            'message' => '獲取個人後台菜單成功',
            'result'    => Auth::user()->getAllPermissions()
        ]);
    }
}
