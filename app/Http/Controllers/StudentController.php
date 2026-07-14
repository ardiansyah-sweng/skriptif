<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()->latest()->get();
        $lecturers = Lecturer::all();
        $studyPrograms = collect();

        if (Schema::hasColumn('students', 'study_program')) {
            $studyPrograms = Student::query()
                ->whereNotNull('study_program')
                ->distinct()
                ->pluck('study_program');
        }

        return view('students.index', compact('students', 'lecturers', 'studyPrograms'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string', 'max:50', 'unique:students,student_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'year_entrance' => ['required', 'integer', 'digits:4'],
            'study_program' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $validated['status'] = $this->resolveStatus($validated['year_entrance'], $validated['status']);

        Student::create($validated);

        return redirect()->route('students.index');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'student_id')->ignore($student->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'year_entrance' => ['required', 'integer', 'digits:4'],
            'study_program' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $validated['status'] = $this->resolveStatus($validated['year_entrance'], $validated['status']);

        $student->update($validated);

        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }

    private function resolveStatus(int $yearEntrance, string $status): string
    {
        return $yearEntrance < Carbon::now()->year - 7 ? 'inactive' : $status;
    }

    public function print(Request $request)
    {
        $query = Student::with(['skripsi.supervisor'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('year_entrance')) {
            $query->where('year_entrance', $request->year_entrance);
        }

        if ($request->filled('study_program')) {
            $query->where('study_program', $request->study_program);
        }

        $searchField = $request->search_field ?: $request->filter;
        $searchValue = $request->search_value ?: $request->value;

        if (!empty($searchField) && !empty($searchValue)) {
            $allowedFields = ['student_id', 'name', 'email'];

            if (in_array($searchField, $allowedFields)) {
                $query->where($searchField, 'like', "%{$searchValue}%");
            }
        }

        if ($request->filled('skripsi_status')) {
            $query->whereHas('skripsi', function ($subQuery) use ($request) {
                $subQuery->where('status', $request->skripsi_status);
            });
        }

        if ($request->filled('supervisor_id')) {
            $query->whereHas('skripsi', function ($subQuery) use ($request) {
                $subQuery->where('supervisor_id', $request->supervisor_id);
            });
        }

        if ($request->filled('graduated')) {
            $query->whereHas('skripsi', function ($subQuery) {
                $subQuery->where('status', 'approved');
            });
        }

        if ($request->filled('date_field')) {
            $allowedDateFields = ['submission_date', 'approval_date'];
            $dateField = $request->date_field;

            if (in_array($dateField, $allowedDateFields)) {
                if ($request->filled('date_start')) {
                    $query->whereHas('skripsi', function ($subQuery) use ($dateField, $request) {
                        $subQuery->whereDate($dateField, '>=', $request->date_start);
                    });
                }

                if ($request->filled('date_end')) {
                    $query->whereHas('skripsi', function ($subQuery) use ($dateField, $request) {
                        $subQuery->whereDate($dateField, '<=', $request->date_end);
                    });
                }
            }
        }

        $students = $query->get();

        $appliedFilters = $request->only([
            'status',
            'year_entrance',
            'study_program',
            'search_field',
            'search_value',
            'skripsi_status',
            'supervisor_id',
            'graduated',
            'date_field',
            'date_start',
            'date_end',
            'output',
        ]);

        if ($request->filled('supervisor_id')) {
            $appliedFilters['supervisor_name'] = Lecturer::find($request->supervisor_id)?->name;
        }

        if ($request->filled('output') && $request->output === 'pdf') {
            if (!class_exists(Pdf::class)) {
                abort(500, 'Package barryvdh/laravel-dompdf perlu terpasang untuk export PDF.');
            }

            return $this->exportPdf($students, $appliedFilters);
        }

        if ($request->filled('output') && $request->output === 'csv') {
            return $this->exportCsv($students);
        }

        return view('students.print', compact('students', 'appliedFilters'));
    }

    protected function exportPdf($students, array $appliedFilters)
    {
        $pdf = Pdf::loadView('students.print', compact('students', 'appliedFilters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('students-report.pdf');
    }

    protected function exportCsv($students)
    {
        $filename = 'students-report.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($students) {
            $output = fopen('php://output', 'w');
            fputcsv($output, [
                'NIM',
                'Nama',
                'Email',
                'Angkatan',
                'Program Studi',
                'Status Mahasiswa',
                'Status Skripsi',
                'Dosen Pembimbing',
                'Tanggal Pengajuan',
                'Tanggal Approval',
            ]);

            foreach ($students as $student) {
                fputcsv($output, [
                    $student->student_id,
                    $student->name,
                    $student->email,
                    $student->year_entrance,
                    $student->study_program,
                    $student->status,
                    optional($student->skripsi)->status,
                    optional(optional($student->skripsi)->supervisor)->name,
                    optional($student->skripsi)->submission_date,
                    optional($student->skripsi)->approval_date,
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}
