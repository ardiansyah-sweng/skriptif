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
        // Ambil semua data dosen aktif dari database untuk dipassing ke dropdown di view
        $lecturers = Lecturer::all(); 
        // Tambahkan variabel $lecturers ke dalam compact()
        return view('skripsi.index', compact('allSkripsi', 'lecturers'));
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

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status'         => 'required|in:approved,rejected',
            'rejection_note' => 'required_if:status,rejected|nullable|string',
            'supervisor_id'  => 'required_if:status,approved|nullable|exists:lecturers,id',
        ], [
            'status.required'            => 'Status wajib ditentukan.',
            'rejection_note.required_if' => 'Alasan penolakan wajib diisi jika judul ditolak.',
            'supervisor_id.required_if'  => 'Dosen pembimbing wajib ditentukan saat menyetujui.',
        ]);

        // ALUR EVALUASI JIKA DISETUJUI (Kondisi Judul Layak)
        if ($request->status === 'approved') {
            $lecturerId = $request->supervisor_id;

            $lecturer = \App\Models\Lecturer::findOrFail($lecturerId);
            $maxQuota = $lecturer->max_quota;

            $activeBimbinganCount = \App\Models\Skripsi::where('supervisor_id', $lecturerId)
                ->where('status', 'approved')
                ->count();

            if ($activeBimbinganCount >= $maxQuota) {
                // Ambil data skripsi yang sedang dievaluasi saat ini
                $currentSkripsi = \App\Models\Skripsi::with('supervisor')->findOrFail($id);
                $requestedDosenName = $currentSkripsi->supervisor->name ?? 'Dosen Pilihan';

                // Mengembalikan pesan instruksi ke Admin untuk memindahkan alokasi dosen pembimbing
                return redirect()->back()->with('error', "Gagal ACC! Slot bimbingan untuk {$requestedDosenName} sudah penuh (Maksimal {$maxQuota} mahasiswa). Judul ini layak diterima, silakan alihkan ke Dosen Pembimbing lain yang slotnya masih tersedia pada dropdown modal.");
            }
        }

        // Jika lolos pengecekan slot bimbingan, simpan ke database via service
        $this->skripsiService->updateStatus($id, $validated);

        return redirect()->route('skripsi.index')->with('success', 'Evaluasi berhasil disimpan dan alokasi dosen diperbarui!');
    }
}