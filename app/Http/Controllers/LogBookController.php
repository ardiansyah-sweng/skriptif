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
        // Mengambil filter pencarian dan status dari URL query
        $search = $request->query('q');
        $status = $request->query('status');
        
        // Memanggil service untuk mendapatkan data log book bimbingan
        $logBooks = $this->logBookService->getAllLogBooks($search, $status);
        
        return view('log_books.index', compact('logBooks', 'search', 'status'));
    }

    /**
     * Display a print layout of the resource.
     */
    public function printAll(Request $request)
    {
        // Mengambil student_id dari parameter query URL
        $studentId = $request->query('student_id');
        
        // Membatalkan akses cetak jika student_id tidak disertakan (karena cetak umum seluruh mahasiswa sudah dihapus)
        if (!$studentId) {
            return redirect()->route('log-books.index')->with('error', 'Silakan tentukan mahasiswa terlebih dahulu untuk mencetak log book.');
        }
        
        // Mengambil data log book bimbingan khusus mahasiswa ini saja
        $logBooks = $this->logBookService->getAllLogBooks(null, null, $studentId);
        
        // Mengambil profil mahasiswa beserta judul skripsi dan dosen pembimbingnya
        $student = Student::with(['skripsi.supervisor'])->findOrFail($studentId);
        
        return view('log_books.print', compact('logBooks', 'studentId', 'student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::where('status', 'active')
            ->whereHas('skripsi', function ($query) {
                $query->whereNotNull('supervisor_id');
            })
            ->with('skripsi')
            ->get();
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
            'attachment'  => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
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
            'attachment.file'      => 'File harus berupa berkas yang valid.',
            'attachment.mimes'     => 'Format file harus jpeg, png, jpg, atau pdf.',
            'attachment.max'       => 'Ukuran file maksimal 2MB.',
        ]);

        // Mengunggah file gambar lampiran jika ada berkas yang dipilih oleh pengguna
        if ($request->hasFile('attachment')) {
            // Simpan gambar di folder storage/app/public/attachments secara otomatis
            $path = $request->file('attachment')->store('attachments', 'public');
            $validated['attachment'] = $path;
        }

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
        $students = Student::where(function ($query) {
                $query->where('status', 'active')
                    ->whereHas('skripsi', function ($q) {
                        $q->whereNotNull('supervisor_id');
                    });
            })
            ->orWhere('id', $logBook->student_id)
            ->with('skripsi')
            ->get();
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
            'attachment'  => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
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
            'attachment.file'      => 'File harus berupa berkas yang valid.',
            'attachment.mimes'     => 'Format file harus jpeg, png, jpg, atau pdf.',
            'attachment.max'       => 'Ukuran file maksimal 2MB.',
        ]);

        $logBook = $this->logBookService->getLogBookById($id);

        // Mengunggah file gambar baru jika ada berkas baru yang dipilih
        if ($request->hasFile('attachment')) {
            // Hapus file gambar lama dari folder penyimpanan jika sebelumnya sudah ada lampiran
            if ($logBook->attachment) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($logBook->attachment);
            }
            // Simpan file gambar yang baru diunggah ke storage
            $path = $request->file('attachment')->store('attachments', 'public');
            $validated['attachment'] = $path;
        }

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
