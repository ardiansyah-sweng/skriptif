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

    public function create()
    {
        return view('elective_courses.create');
    }

    public function store(Request $request)
    {
        $request->validate(['courses' => 'required|string|max:255']);

        DB::table('elective_courses')->insert([
            'courses'   => $request->courses,
            'timestamp' => now(),
        ]);

        return redirect()->route('elective-courses.index');
    }

    public function show($id)
    {
        $course = DB::table('elective_courses')->where('id', $id)->first();

        abort_if(!$course, 404);

        return view('elective_courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = DB::table('elective_courses')->where('id', $id)->first();

        abort_if(!$course, 404);

        return view('elective_courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['courses' => 'required|string|max:255']);
        DB::table('elective_courses')->where('id', $id)->update([
            'courses' => $request->courses,
        ]);
        return redirect()->route('elective-courses.index');
    }

    public function destroy($id)
    {
        DB::table('elective_courses')->where('id', $id)->delete();
        return redirect()->route('elective-courses.index');
    }
}