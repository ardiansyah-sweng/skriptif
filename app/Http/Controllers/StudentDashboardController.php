<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ExamSchedule;
use App\Models\LogBook;
use App\Models\Skripsi;
use App\Models\Student;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Mengikuti pola yang sama dengan StudentSkripsiController
        $student = Student::first();

        $skripsi       = null;
        $logBooks      = collect();
        $examSchedules = collect();

        if ($student) {
            // Ambil data skripsi mahasiswa beserta pembimbing
            $skripsi = Skripsi::where('student_id', $student->id)
                ->with('supervisor')
                ->latest()
                ->first();

            // Ambil 5 log book bimbingan terbaru
            $logBooks = LogBook::where('student_id', $student->id)
                ->with('lecturer')
                ->latest('date')
                ->take(5)
                ->get();

            // Ambil jadwal sidang jika ada skripsi
            if ($skripsi) {
                $examSchedules = ExamSchedule::where('skripsi_id', $skripsi->id)
                    ->orderBy('tanggal_sidang', 'asc')
                    ->get();
            }
        }

        // Ambil 5 pengumuman terbaru yang sudah dipublish
        $announcements = Announcement::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        // Hitung total log book mahasiswa
        $totalLogBooks = $student
            ? LogBook::where('student_id', $student->id)->count()
            : 0;

        return view('students.dashboard', compact(
            'student',
            'skripsi',
            'logBooks',
            'examSchedules',
            'announcements',
            'totalLogBooks'
        ));
    }
}
