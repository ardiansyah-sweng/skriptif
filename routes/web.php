<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
}); 
Route::resource('elective-courses', ElectiveCourseController::class);
Route::post('students/import', [App\Http\Controllers\StudentController::class, 'import'])->name('students.import');
Route::resource('students', StudentController::class);