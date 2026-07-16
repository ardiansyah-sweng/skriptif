<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Skripsi;
use App\Models\LogBook;
use App\Models\ExamSchedule;
use App\Models\ElectiveCourse;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalSkripsi = Skripsi::count();
        $skripsiPending = Skripsi::where('status', 'pending')->count();
        $skripsiApproved = Skripsi::where('status', 'approved')->count();
        $skripsiRejected = Skripsi::where('status', 'rejected')->count();
        $totalLogBooks = LogBook::count();
        $totalExamSchedules = ExamSchedule::count();
        $totalElectiveCourses = ElectiveCourse::count();
        $totalAnnouncements = Announcement::count();

        $recentSkripsi = Skripsi::with('student')
            ->latest()
            ->take(5)
            ->get();

        $recentLogBooks = LogBook::with('student', 'lecturer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalStudents',
            'totalLecturers',
            'totalSkripsi',
            'skripsiPending',
            'skripsiApproved',
            'skripsiRejected',
            'totalLogBooks',
            'totalExamSchedules',
            'totalElectiveCourses',
            'totalAnnouncements',
            'recentSkripsi',
            'recentLogBooks'
        ));
    }
}
