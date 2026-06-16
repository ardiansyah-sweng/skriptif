<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    return view('welcome');
}); 

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('elective-courses', ElectiveCourseController::class);

Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
