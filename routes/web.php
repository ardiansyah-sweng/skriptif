<?php

use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\SkripsiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('log-books', LogBookController::class);
Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
Route::post('lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
