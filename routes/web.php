<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tagController;
use App\Http\Controllers\authController;
use App\Http\Controllers\listController;
use App\Http\Controllers\taskController;

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

Route::resource('/list', listController::class)->middleware('isLogin');
Route::resource('/task', taskController::class)->middleware('isLogin');
Route::resource('/tag', tagController::class)->middleware('isLogin');
Route::post('/search',[listController::class,'searching']);


//auth router
Route::get('/loginpage',[authController::class,'loginPage'])->middleware('isLoged');;
Route::get('/registerpage',[authController::class,'registerPage'])->middleware('isLoged');;
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/profile',[AuthController::class,'profile'])->middleware('isLogin');
Route::get('/ondeadline',[listController::class,'ondeadline'])->middleware('isLogin');
Route::get('/ontime',[listController::class,'ontime'])->middleware('isLogin');
Route::get('/onedaybefore',[listController::class,'onedaybefore'])->middleware('isLogin');
Route::get('/trash', [listController::class, 'trash'])->middleware('isLogin');
Route::get('/restore/{id}', [listController::class, 'restore'])->middleware('isLogin');
Route::get('/delete-permanent/{id}', [ListController::class, 'forceDelete'])->middleware('isLogin');
Route::get('/restore-all', [ListController::class, 'restoreAll'])->middleware('isLogin');
Route::get('/delete-all-permanent', [ListController::class, 'forceDeleteAll'])->middleware('isLogin');
Route::get('/list/{id}/toggle-pin', [ListController::class, 'togglePin'])->name('list.togglePin');
