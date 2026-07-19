<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentSkripsiRequest;
use App\Models\Lecturer;
use App\Models\Skripsi;
use App\Models\ElectiveCourse;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentSkripsiController extends Controller
{
    public function index()
    {
        $student = Student::first();
        $skripsis = $student
            ? Skripsi::where('student_id', $student->id)->with('supervisor')->latest()->get()
            : collect();

        return view('mahasiswa.skripsi.index', compact('skripsis'));
    }

    public function show($id)
    {
        $student = Student::first();
        $skripsi = Skripsi::with('supervisor')->findOrFail($id);

        if ($student && $skripsi->student_id !== $student->id) {
            abort(403);
        }

        return view('mahasiswa.skripsi.index', compact('skripsi'));
    }

    public function create()
    {
        $student = Student::first();
        if (!$student) {
            return redirect()->back()->with('error', 'Tidak ada data mahasiswa.');
        }

        $lecturers = Lecturer::all();
        $electiveCourses = ElectiveCourse::all();

        $lecturersWithCapacity = $lecturers->map(function ($lecturer) use ($student) {
            $approvedCount = Skripsi::where('supervisor_id', $lecturer->id)
                ->where('status', 'approved')
                ->whereHas('student', function ($q) use ($student) {
                    $q->where('year_entrance', $student->year_entrance);
                })
                ->count();

            $maxCapacity = $lecturer->max_supervisors ?? 3;
            $remainingCapacity = max(0, $maxCapacity - $approvedCount);

            return [
                'id'                  => $lecturer->id,
                'name'                => $lecturer->name,
                'max_supervisors'     => $maxCapacity,
                'approved_count'      => $approvedCount,
                'remaining_capacity'  => $remainingCapacity,
                'is_available'        => $remainingCapacity > 0,
            ];
        });

        return view('mahasiswa.skripsi.create', compact('lecturersWithCapacity', 'electiveCourses'));
    }

 public function store(StoreStudentSkripsiRequest $request)
{
    $student = Student::first();

    if (!$student) {
        return redirect()->back()->with('error', 'Tidak ada data mahasiswa.');
    }

    $lecturer = Lecturer::find($request->supervisor_id);
    if (!$lecturer) {
        return back()->with('error', 'Dosen pembimbing tidak valid.');
    }

    $studentYearEntrance = $student->year_entrance;

    $approvedSupervisorCount = Skripsi::where('supervisor_id', $lecturer->id)
        ->where('status', 'approved')
        ->whereHas('student', function ($q) use ($studentYearEntrance) {
            $q->where('year_entrance', $studentYearEntrance);
        })
        ->count();

    if ($approvedSupervisorCount >= (int) ($lecturer->max_supervisors ?? 3)) {
        return back()->withErrors([
            'supervisor_id' => 'Dosen pembimbing ini sudah mencapai batas maksimal mahasiswa dari angkatan ' . $studentYearEntrance . '.'
        ])->withInput();
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

    public function update(Request $request, $id)
    {
        $skripsi = Skripsi::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'supervisor_id' => 'required|exists:lecturers,id',
        ]);

        $skripsi->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'supervisor_id' => $validated['supervisor_id'],
        ]);

        return redirect()->route('student.skripsi.show', $skripsi->id)
            ->with('success', 'Data skripsi berhasil diperbarui.');
    }

    public function history()
    {
        $student = Student::first();
        $skripsis = $student
            ? Skripsi::where('student_id', $student->id)->with('supervisor')->latest()->get()
            : collect();

        return view('mahasiswa.skripsi.submissions', compact('skripsis'));
    }
}