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
use App\Http\Controllers\EventController;
use App\Http\Controllers\SanctionController;



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
Route::post("/player/indexById",[PlayerController::class,'indexPlayersById']);
Route::post("/player/indexByEvent",[PlayerController::class,'indexPlayersByEvent']);


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
Route::post("/extra/indexByEvent",[ExtraController::class,'indexExtrasByEvent']);



Route::get("/league",[LeagueController::class, 'index']);
Route::post("/league/create",[LeagueController::class, 'create']);
Route::put("/league/{id}",[LeagueController::class, 'update']);
Route::delete("/league/{id}",[LeagueController::class,'destroy']);

Route::get("/team",[TeamController::class,'index']);
Route::post("/team/create",[TeamController::class,'create']);
Route::delete("/team/{id}",[TeamController::class,'destroy']);
Route::put("/team/{id}",[TeamController::class,'update']);
Route::get("/getTeams",[TeamController::class,'getTeams']);

Route::get("/referee",[RefereeController::class,'index']);
Route::post("/referee/create",[RefereeController::class,'create']);
Route::delete("/referee/{id}",[RefereeController::class,'destroy']);
Route::put("/referee/{id}",[RefereeController::class,'update']);


Route::get("/event",[EventController::class,'index']);
Route::get("/event/list",[EventController::class,'indexList']);
Route::put("/event/{id}",[EventController::class,'update']);
Route::get("/event/create/set",[EventController::class,'createEventSet']);
Route::get("/event/create/point",[EventController::class,'createEventPoint']);
Route::get("/event/create/markUp",[EventController::class,'createEventMarkUp']);
Route::get("/event/create/markDown",[EventController::class,'createEventMarkDown']);
Route::delete("/event/list/{id}",[EventController::class,'destroy']);
Route::put("/event/edit/{id}",[EventController::class,'editEvent']);

Route::get("/sanction",[SanctionController::class,'index']);
Route::post("/sanction/create",[SanctionController::class,'create']);

