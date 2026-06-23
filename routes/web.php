<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;

Route::get('/', function () {
    return view('welcome');
}); 
Route::resource('elective-courses', ElectiveCourseController::class);
Route::view('/login', 'auth.login')->name('login');

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::view('/dashboard', 'mahasiswa.dashboard')
            ->name('dashboard');

        Route::prefix('skripsi')
            ->name('skripsi.')
            ->group(function () {
                Route::view('/create', 'mahasiswa.skripsi.create')
                    ->name('create');

            });
    });