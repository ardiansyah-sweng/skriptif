<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\SkripsiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('elective-courses', ElectiveCourseController::class);

Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');