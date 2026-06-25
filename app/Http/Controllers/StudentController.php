<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\ImportStudentRequest;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()->latest()->get();

        return view('students.index', compact('students'));
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
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

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
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $student->update($validated);

        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }

    /**
     * Import students from excel file.
     */
    public function import(ImportStudentRequest $request, StudentService $service)
    {
        $service->importExcel($request->file('file'));
        
        return redirect()->route('students.index')
                         ->with('success', 'Mahasiswa berhasil diimpor.');
    }
}