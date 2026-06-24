<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentSkripsiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);

Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');

Route::prefix('mahasiswa/skripsi')->group(function () {
Route::get('/', [StudentSkripsiController::class, 'index'])          
        ->name('student.skripsi.index');
    Route::get('/create', [StudentSkripsiController::class, 'create'])
        ->name('student.skripsi.create');

    Route::post('/', [StudentSkripsiController::class, 'store'])
        ->name('student.skripsi.store');

    Route::get('/history', [StudentSkripsiController::class, 'history'])
        ->name('student.skripsi.history');
});