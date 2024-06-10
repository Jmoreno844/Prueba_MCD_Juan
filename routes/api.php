<?php

use App\Http\Controllers\Api\v1\UserController as UserControllerV1;
use App\Http\Controllers\Api\v2\UserController as UserControllerV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['json.response', 'auth:api', 'api.version']], function () {
    Route::get('/check', function (Request $request) {
        $version = $request->route('version');
        $controller = $version === 'v2' ? UserControllerV2::class : UserControllerV1::class;
        return app()->call([$controller, 'check']);
    });
});

Route::group(['middleware' => ['json.response', 'api.version']], function () {
    Route::post('/register', function (Request $request) {
        $version = $request->route('version');
        $controller = $version === 'v2' ? UserControllerV2::class : UserControllerV1::class;
        return app()->call([$controller, 'register']);
    })->name("register");

    Route::post('/login', function (Request $request) {
        $version = $request->route('version');
        $controller = $version === 'v2' ? UserControllerV2::class : UserControllerV1::class;
        return app()->call([$controller, 'login']);
    })->name("login");
});




