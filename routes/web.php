<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSeminarProposalDocumentController;
use App\Http\Controllers\StudentSkripsiController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('evaluations', EvaluationController::class);

    Route::middleware('role:admin')->group(function () {
        Route::get('elective-courses/search', [ElectiveCourseController::class, 'search'])->name('elective-courses.search');
        Route::resource('elective-courses', ElectiveCourseController::class);
        Route::post('elective-courses/import', [ElectiveCourseController::class, 'import'])
            ->name('elective-courses.import');

        Route::resource('students', StudentController::class);
        Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
        Route::get('/students-print', [StudentController::class, 'printAll'])->name('students.print');

        Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
        Route::get('/lecturers-print', [LecturerController::class, 'printAll'])->name('lecturers.print');
        Route::get('/lecturers/create', [LecturerController::class, 'create'])->name('lecturers.create');
        Route::get('/lecturers/{id}/edit', [LecturerController::class, 'edit'])->name('lecturers.edit');
        Route::get('/lecturers/{id}', [LecturerController::class, 'show'])->name('lecturers.show');
        Route::put('/lecturers/{id}', [LecturerController::class, 'update'])->name('lecturers.update');
        Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
        Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');

        Route::resource('exam-schedules', ExamScheduleController::class)->except(['index', 'show']);
        Route::patch('/exam-schedules/{schedule}/status', [ExamScheduleController::class, 'updateStatus'])->name('exam-schedules.update-status');

        Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
        Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
        Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');

        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    Route::middleware('role:admin,dosen')->group(function () {
        Route::resource('exam-schedules', ExamScheduleController::class)->only(['index', 'show']);

        Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');

        Route::get('/log-books-print', [LogBookController::class, 'printAll'])->name('log-books.print');
        Route::resource('log-books', LogBookController::class);
    });

    Route::get('storage/attachments/{filename}', function ($filename) {
        $filename = basename($filename);
        $path = 'attachments/' . $filename;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
    });

    Route::prefix('student/skripsi')->middleware('role:mahasiswa')->group(function () {
        Route::get('/', [StudentSkripsiController::class, 'index'])->name('student.skripsi.index');
        Route::get('/submissions', [StudentSkripsiController::class, 'history'])->name('student.skripsi.history');
        Route::get('/create', [StudentSkripsiController::class, 'create'])->name('student.skripsi.create');
        Route::post('/', [StudentSkripsiController::class, 'store'])->name('student.skripsi.store');

        Route::get('/seminar-proposal/create', [StudentSeminarProposalDocumentController::class, 'create'])
            ->name('seminar-proposal.create');
        Route::post('/seminar-proposal', [StudentSeminarProposalDocumentController::class, 'store'])
            ->name('seminar-proposal.store');
    });

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

    Route::prefix('utilities')->name('utilities.')->group(function () {
        Route::get('/similarity', [UtilityController::class, 'similarityCheck'])->name('similarity');
        Route::post('/similarity', [UtilityController::class, 'similarityCheck'])->name('similarity.check');
        Route::get('/supervisor', [UtilityController::class, 'supervisorRecommendation'])->name('supervisor');
        Route::get('/progress', [UtilityController::class, 'progressTracker'])->name('progress');
        Route::get('/repository', [UtilityController::class, 'documentRepository'])->name('repository');
        Route::get('/repository/download/{file}', [UtilityController::class, 'downloadTemplate'])->name('repository.download');
    });
});
