<?php

use App\Http\Controllers\UserController;
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



//Routes that are forced as json
Route::group(['middleware' => ['json.response']], function () {
    Route::post('/register',  [UserController::class, 'register'])->name("register");
    Route::post('/login',  [UserController::class, 'login'])->name("login");
    Route::get('/check', [UserController::class, 'check']);

});


