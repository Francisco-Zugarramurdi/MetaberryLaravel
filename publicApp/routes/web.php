<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\Authenticate;
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
    return view('landing');
});

Route::get('/login', function () {
    return view('log-in');
});

Route::get('/signup', function () {
    return view('sign-up');
});
Route::get('/scores',function(){
    return view('scores');
});

Route::post('/login',[AuthController::class,'Login']);
Route::post('/signup',[AuthController::class,'Sign']);
Route::post('/logout',[AuthController::class,'Logout']);

Route::post('/userData',[UserController::class,'Navbar']);

Route::post('/events',[EventController::class,'Index']);
Route::post('/sports',[EventController::class,'IndexSport']);
Route::post('/countries',[EventController::class,'IndexCountry']);