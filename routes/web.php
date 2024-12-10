<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RubricController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();
Route::post('/loginUser', [IndexController::class, 'checkUser'])->name('loginUser');
Route::post('/logoutUser', [IndexController::class, 'logoutUser'])->name('logoutUser');
Route::post('/registerUser', [IndexController::class, 'registerUser'])->name('registerUser');
Route::get('/login-user', [IndexController::class, 'toLoginUser'])->name('login-user');
Route::get('/register-user', [IndexController::class, 'toRegisterUser'])->name('register-user');

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/rubrika/{rubric_id}', [IndexController::class, 'rubrika'])->name('rubrika');
Route::get('/rubrics/create', [RubricController::class, 'create'])->name('rubrics.create');
Route::post('/rubrics', [RubricController::class, 'store'])->name('rubrics.store');

Route::get('/statya/{id}', [IndexController::class, 'statya'])->name('statya');
Route::get('/add', [IndexController::class, 'create'])->name('add.create');
Route::post('/add', [IndexController::class, 'store'])->name('add.store');
Route::delete('/statya/{id}', [IndexController::class, 'destroy'])->name('statya.destroy');
