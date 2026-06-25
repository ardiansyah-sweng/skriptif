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
Route::view('/login', 'students.auth.login')
    ->name('login');

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::view('/dashboard', 'mahasiswa.dashboard')
            ->name('dashboard');

        Route::prefix('skripsi')
            ->name('skripsi.')
            ->group(function () {
                Route::view('/create', 'students.skripsi.create')
                ->name('create');

            });
    });

Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');

Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');

// Group rute untuk student/skripsi
Route::prefix('student/skripsi')->group(function () {
    Route::get('/', [StudentSkripsiController::class, 'index'])          
        ->name('student.skripsi.index');
        
    // TETAP CREATE: Tidak jadi diubah
    Route::get('/create', [StudentSkripsiController::class, 'create'])
        ->name('student.skripsi.create');

    Route::post('/', [StudentSkripsiController::class, 'store'])
        ->name('student.skripsi.store');

    // REVISI: Hanya mengubah URL '/history' menjadi '/submissions'
    Route::get('/submissions', [StudentSkripsiController::class, 'history'])
        ->name('student.skripsi.history');
});

Route::get(
    '/skripsi/{id}/edit',
    [SkripsiController::class, 'edit']
)->name('skripsi.edit');

Route::put(
    '/skripsi/{id}',
    [SkripsiController::class, 'update']
)->name('skripsi.update');