<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
}); 
Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);
