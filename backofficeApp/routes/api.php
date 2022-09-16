<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AdTagController;

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

Route::delete("/user/{id}",[UserController::class,'destroy']);
Route::post("/user/create",[UserController::class,'create']);
Route::get("/user/{email}",[UserController::class,'indexByEmail']);
Route::get("/user",[UserController::class,'index']);
Route::put("/user/{id}",[UserController::class,'update']);


Route::post("/ads/create",[ad::class,'create']);
Route::get("/ads",[ad::class,'index']);
Route::put("/ads/{id}",[ad::class,'update']);
Route::delete("/ads/{id}",[ad::class,'destroy']);


Route::post("/adTag/create",[AdTagController::class,'create']);
Route::put("/adTag/{id}",[AdTagController::class,'update']);
Route::delete("/adTag/{id}",[AdTagController::class,'destroy']);
Route::get("/adTag",[AdTagController::class,'index']);

