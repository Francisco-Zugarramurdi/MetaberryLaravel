<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


Route::post('/login',[AuthController::class,'Login']);
Route::post('/signup',[AuthController::class,'Sign']);
Route::post('/logout',[AuthController::class,'Logout']);
