<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group(function ($router) {
    $router->post('login',     [UserController::class, 'login']);
    $router->post('register', [UserController::class, 'register']);

    $router->middleware('auth:api')->group(function ($router) {
        $router->get('information',  [UserController::class, 'information']);
        $router->post('logout',      [UserController::class, 'logout']);
        $router->post('refresh',     [UserController::class, 'refresh']);
        $router->post('/avatar',     [UserController::class, 'upload']);
        $router->put('/',            [UserController::class, 'profile']);
    });
});


Route::apiResource('article', ArticleController::class);

Route::apiResource('categorie', CategorieController::class);

Route::apiResource('serie', SerieController::class);

Route::prefix('admin')->middleware('auth:api')->group(function ($router) {
    $router->get('menu/self', [MenuController::class, 'menuSelf']);
    $router->apiResource('menu', MenuController::class);

    $router->apiResource('role', RoleController::class);

    $router->apiResource('permission', PermissionController::class);
});
