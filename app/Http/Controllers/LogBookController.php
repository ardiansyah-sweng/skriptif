<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\LogBookService;
use App\Models\Student;
use App\Models\Lecturer;

class LogBookController extends Controller
{
    protected $logBookService;

    public function __construct(LogBookService $logBookService)
    {
        $this->logBookService = $logBookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $status = $request->query('status');
        
        $logBooks = $this->logBookService->getAllLogBooks($search, $status);
        
        return view('log_books.index', compact('logBooks', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::where('status', 'active')->with('skripsi')->get();
        $lecturers = Lecturer::all();
        
        return view('log_books.create', compact('students', 'lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'date'        => 'required|date',
            'activity'    => 'required|string|min:5',
            'feedback'    => 'nullable|string',
            'status'      => 'required|in:pending,approved,rejected',
        ], [
            'student_id.required'  => 'Mahasiswa wajib dipilih.',
            'student_id.exists'    => 'Mahasiswa tidak valid.',
            'lecturer_id.required' => 'Dosen wajib dipilih.',
            'lecturer_id.exists'   => 'Dosen tidak valid.',
            'date.required'        => 'Tanggal bimbingan wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'activity.required'    => 'Laporan aktivitas bimbingan wajib diisi.',
            'activity.min'         => 'Laporan aktivitas bimbingan minimal 5 karakter.',
            'status.required'      => 'Status bimbingan wajib dipilih.',
            'status.in'            => 'Status tidak valid.',
        ]);

        $this->logBookService->storeLogBook($validated);

        return redirect()->route('log-books.index')->with('success', 'Log Book bimbingan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $logBook = $this->logBookService->getLogBookById($id);
        return view('log_books.show', compact('logBook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $logBook = $this->logBookService->getLogBookById($id);
        $students = Student::where('status', 'active')->with('skripsi')->get();
        $lecturers = Lecturer::all();

        return view('log_books.edit', compact('logBook', 'students', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'date'        => 'required|date',
            'activity'    => 'required|string|min:5',
            'feedback'    => 'nullable|string',
            'status'      => 'required|in:pending,approved,rejected',
        ], [
            'student_id.required'  => 'Mahasiswa wajib dipilih.',
            'student_id.exists'    => 'Mahasiswa tidak valid.',
            'lecturer_id.required' => 'Dosen wajib dipilih.',
            'lecturer_id.exists'   => 'Dosen tidak valid.',
            'date.required'        => 'Tanggal bimbingan wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'activity.required'    => 'Laporan aktivitas bimbingan wajib diisi.',
            'activity.min'         => 'Laporan aktivitas bimbingan minimal 5 karakter.',
            'status.required'      => 'Status bimbingan wajib dipilih.',
            'status.in'            => 'Status tidak valid.',
        ]);

        $this->logBookService->updateLogBook($id, $validated);

        return redirect()->route('log-books.index')->with('success', 'Log Book bimbingan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->logBookService->deleteLogBook($id);

        return redirect()->route('log-books.index')->with('success', 'Log Book bimbingan berhasil dihapus!');
    }
}
