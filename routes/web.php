<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectiveCourseController;

Route::get('/', function () {
    return view('welcome');
}); 
Route::resource('elective-courses', ElectiveCourseController::class);
