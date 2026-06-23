<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;

Route::get('/', function () {
    return view('welcome');
}); 
Route::resource('elective-courses', ElectiveCourseController::class);
Route::post('lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');