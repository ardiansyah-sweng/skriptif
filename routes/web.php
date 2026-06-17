<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    return view('welcome');
}); 

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);
Route::resource('lecturers', LecturerController::class);
