<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectHome;
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
})->middleware(RedirectHome::class);

Route::get('/signup', function () {
    return view('sign-up');
})->middleware(RedirectHome::class);

Route::get('/scores', function () {
    return view('scores');
});

Route::get('/subscribe', function () {
    return view('subscribe');
})->middleware(Authenticate::class);

Route::get('/user', function () {
    return view('user-profile');
})->middleware(Authenticate::class);

Route::get('/user/edit', function () {
    return view('edit-user-profile');
})->middleware(Authenticate::class);

Route::post('/login',[AuthController::class,'Login']);
Route::post('/signup',[AuthController::class,'Sign']);
Route::post('/logout',[AuthController::class,'Logout']);
Route::post('/userData',[UserController::class,'getUserData']);
Route::post('/user/edit',[UserController::class,'Update']);