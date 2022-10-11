<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ExtraController;
use App\Http\Controllers\RefereeController;


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
Route::post("/ads/addTag",[AdController::class,'addTag']);

Route::get("/player",[PlayerController::class,'index']);
Route::post("/player/create",[PlayerController::class,'create']);
Route::put("/player/{id}",[PlayerController::class,'update']);
Route::delete("/player/{id}",[PlayerController::class,'destroy']);
Route::post("/player/addTeam",[PlayerController::class,'addTeam']);

Route::get("/sport",[SportController::class, 'index']);
Route::post("/sport/create",[SportController::class, 'create']);
Route::put("/sport/{id}",[SportController::class, 'update']);
Route::delete("/sport/{id}",[SportController::class,'destroy']);

Route::get("/country",[CountryController::class, 'index']);
Route::post("/country/create",[CountryController::class, 'create']);
Route::put("/country/{id}",[CountryController::class, 'update']);
Route::delete("/country/{id}",[CountryController::class,'destroy']);

Route::get("/extra",[ExtraController::class, 'index']);
Route::post("/extra/create",[ExtraController::class, 'create']);
Route::put("/extra/{id}",[ExtraController::class, 'update']);
Route::delete("/extra/{id}",[ExtraController::class,'destroy']);

Route::get("/league",[LeagueController::class, 'index']);
Route::post("/league/create",[LeagueController::class, 'create']);
Route::put("/league/{id}",[LeagueController::class, 'update']);
Route::delete("/league/{id}",[LeagueController::class,'destroy']);

Route::get("/team",[TeamController::class,'index']);
Route::post("/team/create",[TeamController::class,'create']);
Route::delete("/team/{id}",[TeamController::class,'destroy']);
Route::put("/team/{id}",[TeamController::class,'update']);

Route::get("/referee",[RefereeController::class,'index']);
Route::post("/referee/create",[RefereeController::class,'create']);
Route::delete("/referee/{id}",[RefereeController::class,'destroy']);
Route::put("/referee/{id}",[RefereeController::class,'update']);