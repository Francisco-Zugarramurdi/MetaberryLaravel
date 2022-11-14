<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::post("/user/create",[UserController::class,'create']);
Route::post("/user/authenticate",[UserController::class,'authenticate']);
Route::get("/user/{id}",[UserController::class,'Index']);
Route::post("/user/{id}",[UserController::class,'Update']);