<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\ImportStudentRequest;
use App\Services\StudentService;

class StudentController extends Controller
{
    /**
     * Display a listing of all students.
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|unique:students|string|max:20',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:students|max:255',
            'year_entrance' => 'required|integer|min:2000|max:2099',
            'status'        => 'required|in:active,inactive',
        ]);

        Student::create($request->all());
        
        return redirect()->route('students.index')
                         ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in database.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id'    => 'required|string|max:20|unique:students,student_id,' . $student->id,
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:students,email,' . $student->id,
            'year_entrance' => 'required|integer|min:2000|max:2099',
            'status'        => 'required|in:active,inactive',
        ]);

        $student->update($request->all());
        
        return redirect()->route('students.index')
                         ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student from database.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        
        return redirect()->route('students.index')
                         ->with('success', 'Mahasiswa berhasil dihapus.');
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