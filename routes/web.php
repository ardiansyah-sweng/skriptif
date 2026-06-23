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

                Route::view('/', 'mahasiswa.skripsi.index')
                    ->name('index');

                Route::view('/create', 'mahasiswa.skripsi.create')
                    ->name('create');

                Route::view('/{id}', 'mahasiswa.skripsi.show')
                    ->name('show');

                Route::view('/{id}/edit', 'mahasiswa.skripsi.edit')
                    ->name('edit');

            });
    });