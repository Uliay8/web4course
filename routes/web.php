<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();
Route::post('/loginUser', [UserController::class, 'checkUser'])->name('loginUser');
Route::post('/logoutUser', [UserController::class, 'logoutUser'])->name('logoutUser');
Route::post('/registerUser', [UserController::class, 'registerUser'])->name('registerUser');
Route::get('/login-user', [UserController::class, 'toLoginUser'])->name('login-user');
Route::get('/register-user', [UserController::class, 'toRegisterUser'])->name('register-user');
//
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/type/{type_id}', [IndexController::class, 'type'])->name('type');
Route::get('/cabinet', [IndexController::class, 'cabinet'])->name('cabinet');

Route::get('/confirm-ws/{ws_id}', [IndexController::class, 'toConfirm'])->name('confirm-ws');
Route::post('/storePart/{id}', [IndexController::class, 'storePart'])->name('storePart');
Route::get('/toCancelWs/{type_id}', [IndexController::class, 'toCancelWs'])->name('toCancelWs');
//Route::get('/rubrics/create', [RubricController::class, 'create'])->name('rubrics.create');
//Route::post('/rubrics', [RubricController::class, 'store'])->name('rubrics.store');
//
//Route::get('/statya/{id}', [IndexController::class, 'statya'])->name('statya');
//Route::get('/add', [IndexController::class, 'create'])->name('add.create');
//Route::post('/add', [IndexController::class, 'store'])->name('add.store');
//Route::delete('/statya/{id}', [IndexController::class, 'destroy'])->name('statya.destroy');
