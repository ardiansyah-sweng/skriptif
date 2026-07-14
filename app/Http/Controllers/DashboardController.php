<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Skripsi;
use App\Models\ExamSchedule;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents      = Student::count();
        $totalLecturers     = Lecturer::count();
        $totalSkripsi       = Skripsi::count();
        $totalExamSchedules = ExamSchedule::count();

        $recentSkripsi = Skripsi::with(['student', 'supervisor'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalStudents', 'totalLecturers',
            'totalSkripsi', 'totalExamSchedules',
            'recentSkripsi'
        ));
    }
}
