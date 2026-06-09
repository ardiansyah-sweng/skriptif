<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElectiveCourseController extends Controller
{
    public function index()
    {
        $courses = DB::table('elective_courses')->get();
        return view('elective_courses.index', compact('courses'));
    }
}