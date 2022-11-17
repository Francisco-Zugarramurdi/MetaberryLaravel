<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectHome;
use App\Http\Middleware\RedirectRegister;
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

Route::get('/login', function () {
    return view('log-in');
})->middleware(RedirectHome::class);

Route::get('/signup', function () {
    return view('sign-up');
})->middleware(RedirectHome::class);

Route::get('/subscribe', function () {
    return view('subscribe');
})->middleware(RedirectRegister::class)->name('subscribe');

Route::get('/user',[UserController::class,'GetIndexView'])->middleware(Authenticate::class);
Route::get('/user/edit',[UserController::class,'GetEditView'])->middleware(Authenticate::class);
Route::get('/scores',[UserController::class,'GetScoreView']);
Route::get('/',[UserController::class,'GetLandingView'])->middleware(RedirectHome::class);

Route::post('/login',[AuthController::class,'Login']);
Route::post('/signup',[AuthController::class,'Sign']);
Route::post('/logout',[AuthController::class,'Logout']);
Route::post('/user/edit',[UserController::class,'Update']);
Route::post('/user/subscription',[UserController::class,'Suscribe']);
Route::post('/user/subscription/delete',[UserController::class,'DeleteSubscription']);
Route::post('/user/subscription/update',[UserController::class,'UpdateSubscription']);

Route::post('/events',[EventController::class,'Index']);
Route::post('/sports',[EventController::class,'IndexSport']);
Route::post('/countries',[EventController::class,'IndexCountry']);

Route::get('/event/{id}',[EventController::class,'IndexEvent']);
Route::get('/event/mark/{id}',[EventController::class,'IndexEventMark']);
