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
Route::get("/personCreate/", [IndexController::class, 'personCreate'])->name('person.create');
Route::post('/persons', [IndexController::class, 'store'])->name('person.store');
Route::get('/person', [IndexController::class, 'index'])->name('person.index');
Route::delete('/persons/{id}', [IndexController::class, 'destroy'])->name('person.destroy');
Route::get('/persons/{id}/edit', [IndexController::class, 'edit'])->name('person.edit');
Route::put('/persons/{id}', [IndexController::class, 'update'])->name('person.update');


