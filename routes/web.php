<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\listController;
use App\Http\Controllers\tagController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome')->with(['header' => 'welcome elist']);
});

Route::resource('/list', listController::class);
Route::resource('/task', taskController::class);
Route::resource('/tag', tagController::class);


//auth router
Route::get('/loginpage',[authController::class,'loginPage']);
Route::get('/registerpage',[authController::class,'registerPage']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/logout',[AuthController::class,'logout']);
