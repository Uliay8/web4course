<?php

use Illuminate\Support\Facades\Route;
//
//Route::get('/', function () {
//    return view('welcome');
//});
// {from}/{to}
use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index']);
Route::get('/show/{id}', [IndexController::class, 'show']);
Route::get("/showPersonsByStage/", [IndexController::class, 'showPersonsByStageFromTo']);
Route::get("/showPersonsByStaff/", [IndexController::class, 'showPersonsAndStageByStaff']);
Route::get("/showCountResumes/", [IndexController::class, 'showCountResumes']);
Route::get("/showDistinctProfessions/", [IndexController::class, 'showDistinctProfessions']);
