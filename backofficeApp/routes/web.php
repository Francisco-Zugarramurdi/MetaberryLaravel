<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get("/user",[UserController::class,'index']);
Route::post("/user/create",[UserController::class,'create']);
Route::put("/user/{id}",[UserController::class,'update']);
Route::delete("/user/{id}",[UserController::class,'destroy']);


Route::get("/ads",[AdController::class,'index']);
Route::post("/ads/create",[AdController::class,'create']);
Route::put("/ads/{id}",[AdController::class,'update']);
Route::delete("/ads/{id}",[AdController::class,'destroy']);

