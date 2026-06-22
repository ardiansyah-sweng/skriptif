<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\SkripsiController;



Route::get('/', function () {
    return view('welcome');
}); 
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);
Route::resource('lecturers', LecturerController::class);
Route::resource('skripsi', SkripsiController::class);