<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total lecturers
        $totalLecturers = DB::table('lecturers')->count();
        
        // Total active lecturers (all registered lecturers are active since status is not tracked)
        $activeLecturers = DB::table('lecturers')->count();
        
        // Total students
        $totalStudents = DB::table('students')->count();
        
        // Total active students
        $activeStudents = DB::table('students')
            ->where('status', 'active')
            ->count();
        
        // Total elective courses
        $totalCourses = DB::table('elective_courses')->count();
        
        return view('dashboard.index', [
            'totalLecturers' => $totalLecturers,
            'activeLecturers' => $activeLecturers,
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'totalCourses' => $totalCourses,
        ]);
    }
}
