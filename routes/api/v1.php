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

Route::group(['middleware' => ['json.response', 'auth:api']], function () {

    Route::get("/check", [UserControllerV1::class, 'check'])->name("check");

});

Route::group(['middleware' => ['json.response']], function () {

    Route::post("/register", [UserControllerV1::class, 'register'])->name("register");
    Route::post("/login", [UserControllerV1::class, 'login'])->name("login");

});
