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
| contains the "web" middleware group. Now Create something great!
|
*/

Route::get('/', function () {
    return view('Index');
})->middleware('auth');

Route::get("/user",[UserController::class,'Index']);
Route::post("/user/create",[UserController::class,'Create']);
Route::put("/user/{id}",[UserController::class,'Update']);
Route::delete("/user/{id}",[UserController::class,'Destroy']);

Route::get("/user/subscription", [UserController::class, 'IndexSubscription']);
Route::put("/user/subscription/{id}",[UserController::class,'UpdateSubscription']);
Route::delete("/user/subscription/{id}", [UserController::class, 'DestroySubscription']);


Route::get("/ads",[AdController::class,'Index']);
Route::post("/ads/create",[AdController::class,'Create']);
Route::put("/ads/{id}",[AdController::class,'Update']);
Route::delete("/ads/{id}",[AdController::class,'Destroy']);
Route::post("/ads/addTag",[AdController::class,'AddTag']);

Route::get("/player",[PlayerController::class,'Index']);
Route::post("/player/create",[PlayerController::class,'Create']);
Route::put("/player/{id}",[PlayerController::class,'Update']);
Route::delete("/player/{id}",[PlayerController::class,'Destroy']);
Route::post("/player/addTeam",[PlayerController::class,'AddTeam']);
Route::post("/player/indexById",[PlayerController::class,'IndexPlayersById']);
Route::post("/player/indexByEvent",[PlayerController::class,'IndexPlayersByEvent']);


Route::get("/sport",[SportController::class, 'Index']);
Route::post("/sport/create",[SportController::class, 'Create']);
Route::put("/sport/{id}",[SportController::class, 'Update']);
Route::delete("/sport/{id}",[SportController::class,'Destroy']);

Route::get("/country",[CountryController::class, 'Index']);
Route::post("/country/create",[CountryController::class, 'Create']);
Route::put("/country/{id}",[CountryController::class, 'Update']);
Route::delete("/country/{id}",[CountryController::class,'Destroy']);

Route::get("/extra",[ExtraController::class, 'Index']);
Route::post("/extra/create",[ExtraController::class, 'Create']);
Route::put("/extra/{id}",[ExtraController::class, 'Update']);
Route::delete("/extra/{id}",[ExtraController::class,'Destroy']);
Route::post("/extra/indexByEvent",[ExtraController::class,'IndexExtrasByEvent']);



Route::get("/league",[LeagueController::class, 'Index']);
Route::post("/league/create",[LeagueController::class, 'Create']);
Route::put("/league/{id}",[LeagueController::class, 'Update']);
Route::delete("/league/{id}",[LeagueController::class,'Destroy']);
Route::post("/league/byCountry",[LeagueController::class,'IndexLeagueByCountry']);

Route::get("/team",[TeamController::class,'Index']);
Route::post("/team/create",[TeamController::class,'Create']);
Route::delete("/team/{id}",[TeamController::class,'Destroy']);
Route::put("/team/{id}",[TeamController::class,'Update']);
Route::get("/getTeams",[TeamController::class,'GetTeams']);
Route::post("/team/indexBySport",[TeamController::class,'IndexTeamBySport']);


Route::get("/referee",[RefereeController::class,'Index']);
Route::post("/referee/create",[RefereeController::class,'Create']);
Route::delete("/referee/{id}",[RefereeController::class,'Destroy']);
Route::put("/referee/{id}",[RefereeController::class,'Update']);


Route::get("/event",[EventController::class,'Index']);
Route::get("/event/list",[EventController::class,'IndexList']);
Route::put("/event/{id}",[EventController::class,'Update']);
Route::get("/event/create/set",[EventController::class,'CreateEventSet']);
Route::get("/event/create/point",[EventController::class,'CreateEventPoint']);
Route::get("/event/create/markUp",[EventController::class,'CreateEventMarkUp']);
Route::get("/event/create/markDown",[EventController::class,'CreateEventMarkDown']);
Route::delete("/event/list/{id}",[EventController::class,'Destroy']);
Route::get("/event/edit/{id}",[EventController::class,'EventEdit']);
Route::put("/event/edit/set/{id}",[EventController::class,'EditEventSet']);
Route::put("/event/edit/point/{id}",[EventController::class,'EditEventPoint']);
Route::put("/event/edit/markUp/{id}",[EventController::class,'EditEventMarkUp']);
Route::put("/event/edit/markDown/{id}",[EventController::class,'EditEventMarkDown']);

Route::get("/sanction",[SanctionController::class,'Index']);
Route::post("/sanction/create",[SanctionController::class,'Create']);
Route::put("/sanction/{id}",[SanctionController::class,'Update']);
Route::delete("/sanction/{id}",[SanctionController::class,'Destroy']);


Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'Index'])->name('home');
