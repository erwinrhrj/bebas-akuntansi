<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/pengguna', [PenggunaController::class, 'index']);
    Route::post('/pengguna/store', [PenggunaController::class, 'store']);
    Route::post('/pengguna/update', [PenggunaController::class, 'update']);
    Route::post('/pengguna/delete', [PenggunaController::class, 'delete']);

});
