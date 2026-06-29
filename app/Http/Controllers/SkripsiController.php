<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\SkripsiService;
use App\Models\Lecturer;
use App\Models\Student;

class SkripsiController extends Controller
{
    protected $skripsiService;

    public function __construct(SkripsiService $skripsiService)
    {
        $this->skripsiService = $skripsiService;
    }

    // Halaman admin: list semua skripsi
    public function index()
    {
        $allSkripsi = $this->skripsiService->getAllSkripsi();
        return view('skripsi.index', compact('allSkripsi'));
    }

    // Halaman mahasiswa: form pengajuan
    public function create()
    {
        $lecturers = Lecturer::all();
        $students  = Student::where('status', 'active')->get();
        return view('skripsi.create', compact('lecturers', 'students'));
    }

    // Proses submit pengajuan dari mahasiswa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'supervisor_id' => 'required|exists:lecturers,id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
        ], [
            'student_id.required'    => 'Mahasiswa wajib dipilih.',
            'student_id.exists'      => 'Mahasiswa tidak valid.',
            'supervisor_id.required' => 'Dosen Pembimbing wajib dipilih.',
            'supervisor_id.exists'   => 'Dosen yang dipilih tidak valid.',
            'title.required'         => 'Judul skripsi wajib diisi.',
            'description.required'   => 'Deskripsi skripsi wajib diisi.',
        ]);

        $this->skripsiService->submitSkripsi($validated);

        return redirect()->route('skripsi.index')->with('success', 'Pengajuan skripsi berhasil dikirim! Menunggu persetujuan admin.');
    }

    // Proses approve/reject dari admin
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status'         => 'required|in:approved,rejected',
            'rejection_note' => 'required_if:status,rejected|nullable|string',
        ], [
            'status.required'            => 'Status wajib dipilih.',
            'rejection_note.required_if' => 'Catatan penolakan wajib diisi jika skripsi ditolak.',
        ]);

        $this->skripsiService->updateStatus($id, $validated);

        return redirect()->route('skripsi.index')->with('success', 'Status skripsi berhasil diperbarui!');
    }

    // Halaman detail skripsi & timeline untuk admin
    public function show($id)
    {
        $skripsi = \App\Models\Skripsi::with(['student', 'supervisor', 'histories.handler'])->findOrFail($id);
        $courses = \App\Models\ElectiveCourse::all()->pluck('courses', 'id');
        return view('skripsi.show', compact('skripsi', 'courses'));
    }
}