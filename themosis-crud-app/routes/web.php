<?php

/**
 * Application routes.
 */

use Themosis\Support\Facades\Route;
use App\Http\Controllers\PersonController;

/**
 * Define your routes.
 */
Route::get('/', function () {
    return view('welcome');
});

// Rutas del CRUD de Person - Solo accesibles para administradores
Route::group(['middleware' => ['auth', 'can:manage_options']], function () {
    Route::get('/persons', [PersonController::class, 'index'])->name('person.index');
    Route::get('/persons/create', [PersonController::class, 'create'])->name('person.create');
    Route::post('/persons', [PersonController::class, 'store'])->name('person.store');
    Route::get('/persons/{person}', [PersonController::class, 'show'])->name('person.show');
    Route::get('/persons/{person}/edit', [PersonController::class, 'edit'])->name('person.edit');
    Route::put('/persons/{person}', [PersonController::class, 'update'])->name('person.update');
    Route::delete('/persons/{person}', [PersonController::class, 'destroy'])->name('person.destroy');
});