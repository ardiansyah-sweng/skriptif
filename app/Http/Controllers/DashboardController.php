<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\LecturerTopic;
use App\Models\Skripsi;
use App\Models\LogBook;
use App\Models\ExamSchedule;
use App\Models\ElectiveCourse;
use App\Models\Announcement;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'dosen') {
            return $this->dosenDashboard();
        }

        if ($user->role === 'mahasiswa') {
            return $this->mahasiswaDashboard();
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
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
        $totalEvaluations = Evaluation::count();

        $recentSkripsi = Skripsi::with('student')
            ->latest()
            ->take(5)
            ->get();

        $recentLogBooks = LogBook::with('student', 'lecturer')
            ->latest()
            ->take(5)
            ->get();

        $recentEvaluations = Evaluation::with(['skripsi.student', 'lecturer'])
            ->latest('evaluation_date')
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
            'totalEvaluations',
            'recentSkripsi',
            'recentLogBooks',
            'recentEvaluations'
        ));
    }

    private function dosenDashboard()
    {
        $lecturer = Lecturer::where('email', Auth::user()->email)->first();

        $bimbinganCount = 0;
        $recentLogBooks = collect();
        $upcomingSchedules = collect();
        $topics = collect();

        if ($lecturer) {
            $bimbinganCount = Skripsi::where('supervisor_id', $lecturer->id)
                ->whereIn('status', ['approved', 'pending'])
                ->count();

            $recentLogBooks = LogBook::with('student')
                ->where('lecturer_id', $lecturer->id)
                ->latest()
                ->take(5)
                ->get();

            $upcomingSchedules = ExamSchedule::with(['skripsi.student', 'skripsi.supervisor'])
                ->whereHas('skripsi', function ($q) use ($lecturer) {
                    $q->where('supervisor_id', $lecturer->id);
                })
                ->where('tanggal_sidang', '>=', now()->format('Y-m-d'))
                ->orderBy('tanggal_sidang')
                ->orderBy('jam_mulai')
                ->take(10)
                ->get();

            $topics = LecturerTopic::with(['lecturer', 'applications.student'])
                ->withCount('applications')
                ->where('lecturer_id', $lecturer->id)
                ->latest()
                ->take(50)
                ->get();
        }

        $totalAnnouncements = Announcement::count();
        $topicCount = $topics->count();
        $evaluationCount = Evaluation::count();

        $recentEvaluations = Evaluation::with(['skripsi.student', 'lecturer'])
            ->latest('evaluation_date')
            ->take(5)
            ->get();

        $lecturers = Lecturer::all();

        return view('dashboard.dosen', compact(
            'lecturer',
            'bimbinganCount',
            'recentLogBooks',
            'upcomingSchedules',
            'totalAnnouncements',
            'topics',
            'topicCount',
            'evaluationCount',
            'recentEvaluations',
            'lecturers'
        ));
    }

    private function mahasiswaDashboard()
    {
        $student = Student::where('email', Auth::user()->email)->first();

        $skripsi = null;
        $schedules = collect();
        $recentLogBooks = collect();
        $evaluations = collect();

        if ($student) {
            $skripsi = Skripsi::with('supervisor')
                ->where('student_id', $student->id)
                ->latest()
                ->first();

            $schedules = ExamSchedule::with(['skripsi.student', 'skripsi.supervisor'])
                ->whereHas('skripsi', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->orderBy('tanggal_sidang')
                ->get();

            $recentLogBooks = LogBook::with('lecturer')
                ->where('student_id', $student->id)
                ->latest()
                ->take(5)
                ->get();

            $evaluations = Evaluation::with('lecturer')
                ->whereHas('skripsi', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->latest('evaluation_date')
                ->get();
        }

        $totalAnnouncements = Announcement::count();

        return view('dashboard.mahasiswa', compact(
            'student',
            'skripsi',
            'schedules',
            'recentLogBooks',
            'evaluations',
            'totalAnnouncements'
        ));
    }
}
