<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentSkripsiRequest;
use App\Models\Lecturer;
use App\Models\Skripsi;
use App\Models\ElectiveCourse;
use App\Models\Student;

class StudentSkripsiController extends Controller
{
    public function create()
    {
       $lecturers = Lecturer::all();
        $electiveCourses = ElectiveCourse::all();

        return view('mahasiswa.skripsi.create', compact('lecturers', 'electiveCourses'));
    }

 public function store(StoreStudentSkripsiRequest $request)
{
    $student = Student::first();

    if (!$student) {
        return redirect()->back()->with('error', 'Tidak ada data mahasiswa.');
    }

    $electiveData = [];
    if ($request->has('elective_courses')) {
        foreach ($request->elective_courses as $item) {
            if (!empty($item['id'] ?? null)) {
                $electiveData[] = [
                    'id'    => (int) $item['id'],
                    'grade' => $item['grade'] ?? null,
                ];
            }
        }
    }

    try {
        $skripsi = Skripsi::create([
            'student_id'            => $student->id,
            'supervisor_id'         => $request->supervisor_id,
            'title'                 => $request->title,
            'description'           => $request->description,
            'suggestion_supervisor' => $request->suggestion_supervisor,
            'elective_courses'      => $electiveData,
            'status'                => 'pending',
            'submission_date'       => now(),
        ]);

        return redirect()
            ->route('student.skripsi.history')
            ->with('success', 'Pengajuan berhasil!');

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
}

    public function history()
    {
        $student = Student::first();
        $skripsis = $student
            ? Skripsi::where('student_id', $student->id)->with('supervisor')->latest()->get()
            : collect();

        return view('mahasiswa.skripsi.submissions', compact('skripsis'));
    }

    public function show($id)
    {
        $student = Student::first();
        if (!$student) {
            return redirect()->back()->with('error', 'Tidak ada data mahasiswa.');
        }

        $skripsi = Skripsi::where('student_id', $student->id)
            ->with(['supervisor', 'histories.handler'])
            ->findOrFail($id);

        $courses = \App\Models\ElectiveCourse::all()->pluck('courses', 'id');

        return view('mahasiswa.skripsi.show', compact('skripsi', 'courses'));
    }
}