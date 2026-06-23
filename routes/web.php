<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);

Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
Route::get('lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
Route::get('lecturers/{id}/edit', [LecturerController::class, 'edit'])->name('lecturers.edit');
Route::put('lecturers/{id}', [LecturerController::class, 'update'])->name('lecturers.update');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
