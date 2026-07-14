<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Skripsi;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Student::first();
        $skripsi = Skripsi::first();

        return view('dashboard.index', compact('student', 'skripsi'));
    }
}