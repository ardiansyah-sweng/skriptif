<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectiveCourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSkripsiController;
use App\Http\Controllers\StudentSeminarProposalDocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UtilityController;

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

    Route::get('elective-courses/search', [ElectiveCourseController::class, 'search'])->name('elective-courses.search');
    Route::resource('elective-courses', ElectiveCourseController::class);
    Route::resource('students', StudentController::class);
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/students-print', [StudentController::class, 'printAll'])->name('students.print');

    Route::resource('exam-schedules', ExamScheduleController::class);
    Route::patch('/exam-schedules/{schedule}/status', [ExamScheduleController::class, 'updateStatus'])->name('exam-schedules.update-status');

    Route::get('/skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
    Route::get('/skripsi/create', [SkripsiController::class, 'create'])->name('skripsi.create');
    Route::post('/skripsi', [SkripsiController::class, 'store'])->name('skripsi.store');
    Route::put('/skripsi/{id}/update-status', [SkripsiController::class, 'updateStatus'])->name('skripsi.updateStatus');
    Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
    Route::get('/lecturers-print', [LecturerController::class, 'printAll'])->name('lecturers.print');
    Route::get('/lecturers/create', [LecturerController::class, 'create'])->name('lecturers.create');
    Route::get('/lecturers/{id}/edit', [LecturerController::class, 'edit'])->name('lecturers.edit');
    Route::get('/lecturers/{id}', [LecturerController::class, 'show'])->name('lecturers.show');
    Route::put('/lecturers/{id}', [LecturerController::class, 'update'])->name('lecturers.update');
    Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
    Route::delete('/lecturers/{id}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');
    // Rute untuk mencetak log book bimbingan (seluruh mahasiswa atau per mahasiswa) ke PDF/printer
    Route::get('/log-books-print', [LogBookController::class, 'printAll'])->name('log-books.print');
    Route::resource('log-books', LogBookController::class);
    Route::post('elective-courses/import', [ElectiveCourseController::class, 'import'])
        ->name('elective-courses.import');

    // Fallback untuk melayani file lampiran jika link simbolik public/storage rusak atau tidak ada
    Route::get('storage/attachments/{filename}', function ($filename) {
        $filename = basename($filename);
        $path = 'attachments/' . $filename;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404);
        }
        return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
    });

    // Group rute untuk student/skripsi
    Route::prefix('student/skripsi')->group(function () {
        Route::get('/', [StudentSkripsiController::class, 'index'])
            ->name('student.skripsi.index');

    // REVISI: Hanya mengubah URL '/history' menjadi '/submissions'
    Route::get('/submissions', [StudentSkripsiController::class, 'history'])
        ->name('student.skripsi.history');
    
    Route::post('elective-courses/import', [ElectiveCourseController::class, 'import'])
        ->name('elective-courses.import');

// Rute untuk pengumpulan berkas syarat seminar proposal (khusus mahasiswa)
Route::get('/seminar-proposal', [StudentSeminarProposalDocumentController::class, 'index'])
    ->name('seminar-proposal.index');

Route::get('/seminar-proposal/create', [StudentSeminarProposalDocumentController::class, 'create'])
    ->name('seminar-proposal.create');

Route::post('/seminar-proposal', [StudentSeminarProposalDocumentController::class, 'store'])
    ->name('seminar-proposal.store');

        // TETAP CREATE: Tidak jadi diubah
        Route::get('/create', [StudentSkripsiController::class, 'create'])
            ->name('student.skripsi.create');

        Route::post('/', [StudentSkripsiController::class, 'store'])
            ->name('student.skripsi.store');

    // REVISI: Hanya mengubah URL '/history' menjadi '/submissions'
    Route::get('/submissions', [StudentSkripsiController::class, 'history'])
        ->name('student.skripsi.history');
    });

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
});

    Route::prefix('utilities')->name('utilities.')->group(function () {
        Route::get('/similarity', [UtilityController::class, 'similarityCheck'])->name('similarity');
        Route::post('/similarity', [UtilityController::class, 'similarityCheck'])->name('similarity.check');
        Route::get('/supervisor', [UtilityController::class, 'supervisorRecommendation'])->name('supervisor');
        Route::get('/progress', [UtilityController::class, 'progressTracker'])->name('progress');
        Route::get('/repository', [UtilityController::class, 'documentRepository'])->name('repository');
        Route::get('/repository/download/{file}', [UtilityController::class, 'downloadTemplate'])->name('repository.download');
    });
