<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\LecturerTopicController;
use App\Http\Controllers\TopicApplicationController;
use App\Http\Controllers\TopicBoardController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSkripsiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamScheduleController;

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
Route::resource('log-books', LogBookController::class);
Route::resource('lecturer-topics', LecturerTopicController::class);
Route::get('topic-board', [TopicBoardController::class, 'index'])->name('topic-board.index');
Route::get('topic-board/{id}', [TopicBoardController::class, 'show'])->name('topic-board.show');
Route::post('topic-board/{id}/apply', [TopicApplicationController::class, 'store'])->name('topic-board.apply');
Route::get('topic-applications', [TopicApplicationController::class, 'index'])->name('topic-applications.index');
Route::post('topic-applications/{id}/approve', [TopicApplicationController::class, 'approve'])->name('topic-applications.approve');
Route::post('topic-applications/{id}/reject', [TopicApplicationController::class, 'reject'])->name('topic-applications.reject');
Route::delete('topic-applications/{id}', [TopicApplicationController::class, 'destroy'])->name('topic-applications.destroy');

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

// Rute Jadwal Sidang Skripsi (sisi admin)
Route::get('/exam-schedules', [ExamScheduleController::class, 'index'])->name('exam-schedules.index');
Route::get('/exam-schedules/create', [ExamScheduleController::class, 'create'])->name('exam-schedules.create');
Route::post('/exam-schedules', [ExamScheduleController::class, 'store'])->name('exam-schedules.store');
Route::delete('/exam-schedules/{id}', [ExamScheduleController::class, 'destroy'])->name('exam-schedules.destroy');
