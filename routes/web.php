<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSkripsiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login')->name('login');

Route::resource('elective-courses', ElectiveCourseController::class);
Route::resource('students', StudentController::class);

Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
Route::get('/lecturers-print', [LecturerController::class, 'printAll'])->name('lecturers.print');
Route::get('/lecturers/{id}/edit', [LecturerController::class, 'edit'])->name('lecturers.edit');
Route::get('/lecturers/{id}', [LecturerController::class, 'show'])->name('lecturers.show');
Route::put('/lecturers/{id}', [LecturerController::class, 'update'])->name('lecturers.update');
Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
// Rute untuk mencetak log book bimbingan (seluruh mahasiswa atau per mahasiswa) ke PDF/printer
Route::get('/log-books-print', [LogBookController::class, 'printAll'])->name('log-books.print');
Route::resource('log-books', LogBookController::class);

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

// =========================
// Dashboard Mahasiswa
// =========================
Route::prefix('student')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('student.dashboard');

});
