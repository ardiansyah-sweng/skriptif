<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
<<<<<<< HEAD
use App\Http\Controllers\StudentController;
=======
use App\Http\Controllers\LecturerController;
>>>>>>> e02f42db65cfd3377e2f375f573f4f297e8d8884

Route::get('/', function () {
    return view('welcome');
}); 

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('elective-courses', ElectiveCourseController::class);
<<<<<<< HEAD
Route::resource('students', StudentController::class);
=======

Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
>>>>>>> e02f42db65cfd3377e2f375f573f4f297e8d8884
