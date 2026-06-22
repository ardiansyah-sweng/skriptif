<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Lecturer;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('skripsi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
{
    $students = Student::all();
    $lecturers = Lecturer::all();
    $electiveCourses = DB::table('elective_courses')->get();

    return view('skripsi.create', compact(
        'students',
        'lecturers',
        'electiveCourses'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'student_id' => 'required',
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    return redirect()
        ->route('skripsi.index')
        ->with('success', 'Data skripsi berhasil ditambahkan');
    }


// Dummy data sementara sampai model dan database skripsi selesai dibuat
public function show(string $id)
{
    $skripsi = (object)[
        'id' => $id,
        'student_name' => 'Aldrion Wijaya',
        'title' => 'Pengaruh Feature Selection Chi-Square terhadap Performa XGBoost pada Prediksi Stunting Balita',
        'description' => 'Penelitian prediksi stunting menggunakan XGBoost dan Chi-Square.',
        'supervisor' => 'Belum Ditentukan',
        'suggestion_supervisor' => 'Dr. Budi Santoso',
        'status' => 'pending',
        'submission_date' => now(),
        'approval_date' => null,
        'elective_courses' => 'Data Mining, Machine Learning',
        'rejection_note' => null,
    ];

    return view('skripsi.show', compact('skripsi'));
}

// Dummy data sementara sampai model dan database skripsi selesai dibuat
public function edit(string $id)
{
    $students = Student::all();
    $lecturers = Lecturer::all();
    $electiveCourses = DB::table('elective_courses')->get();

    $skripsi = (object)[
        'id' => $id,
        'student_id' => '',
        'supervisor_id' => '',
        'title' => '',
        'description' => '',
        'suggestion_supervisor' => '',
        'elective_courses' => '',
        'status' => 'pending'
    ];

    return view(
        'skripsi.edit',
        compact(
            'skripsi',
            'students',
            'lecturers',
            'electiveCourses'
        )
    );
}


public function update(Request $request, string $id)
{
    $request->validate([
        'student_id' => 'required',
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    return redirect()
        ->route('skripsi.index')
        ->with('success', 'Data skripsi berhasil diperbarui');
}


    public function destroy(string $id)
    {
        return redirect()
        ->route('skripsi.index')
        ->with('success', 'Data skripsi berhasil dihapus');
    }
}