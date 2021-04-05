<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;

class UserController extends Controller
{

    private $userModel;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * 通過給定憑據獲取JWT
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($request)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json([
            'message' => '登入成功',
            'data'    => $this->respondWithToken($token)
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
            $user = $this->userModel->create(array_merge($request->only(['name', 'email']), [
                'password' => bcrypt($request->input('password', ['rounds' => 12]))
            ]));
            if ($user) {
                $token = auth()->login($user);
                return response()->json(['message' => '成功註冊', 'data' => $this->respondWithToken($token)], 201);
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
        return response()->json([
            'message' => '獲取用戶資訊成功',
            'data'    => auth()->user()
        ]);
    }

    /**
     * 記錄用戶（無效令牌）
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
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
            'data'    => $this->respondWithToken(auth()->refresh())
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
            'accessToken' => $token,
            'tokenType'   => 'bearer',
            'expiresIn'   =>  auth()->factory()->getTTL() * 60,
        ];
    }
}