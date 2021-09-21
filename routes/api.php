<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

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
    $router->post('register',  [UserController::class, 'register']);

    $router->middleware('auth:api')->group(function ($router) {
        $router->get('information',  [UserController::class, 'information']);
        $router->get('menu',         [UserController::class, 'menu']);
        $router->post('logout',      [UserController::class, 'logout']);
        $router->post('refresh',     [UserController::class, 'refresh']);
        $router->post('upload',      [UserController::class, 'upload']);
        $router->put('/',            [UserController::class, 'profile']);
    });
});


Route::get('article/{article}/serie/{serie}',        [ArticleController::class, 'showSeriesArticle']);
Route::get('article/{article}/categorie/{categorie}', [ArticleController::class, 'showCategoryArticle']);
Route::apiResource('article', ArticleController::class);

Route::apiResource('categorie', CategorieController::class);

Route::apiResource('serie', SerieController::class);

Route::prefix('admin')->group(function ($router) {
    $router->apiResource('menu', MenuController::class);

    $router->get('/role/page',   [RoleController::class, 'page']);
    $router->apiResource('role', RoleController::class);

    $router->get('/permission/page',   [PermissionController::class, 'page']);
    $router->apiResource('permission', PermissionController::class);

    $router->apiResource('file', FileController::class);
});
