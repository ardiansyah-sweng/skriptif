<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Skripsi;
use App\Models\LogBook;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Student::first();
        $skripsi = Skripsi::first();
        $totalLogBooks = $student
            ? LogBook::where('student_id', $student->id)->count()
            : 0;
        $latestLogBook = $student
            ? LogBook::where('student_id', $student->id)->latest('date')->first()
            : null;

        return view('dashboard.index', compact('student', 'skripsi', 'totalLogBooks', 'latestLogBook'));
    }
}
