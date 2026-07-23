<?php

namespace App\Http\Controllers;

use App\Models\SeminarProposalDocument;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentSeminarProposalDocumentController extends Controller
{
    /**
     * Daftar berkas yang menjadi syarat pengajuan seminar proposal.
     */
    private array $documentFields = [
        'bukti_turnitin'  => 'Bukti Turnitin',
        'bukti_literasi'  => 'Bukti Sertifikat Literasi',
        'bukti_transkrip' => 'Bukti Tanda Tangan Transkrip',
        'bukti_toefl'     => 'Bukti TOEFL',
    ];


    /**
     * Form pemilihan mahasiswa dan pengunggahan berkas seminar proposal.
     */
    public function create(Request $request)
    {
        $students = Student::whereHas('skripsi')->orderBy('name')->get();

        $student = null;
        $skripsi = null;
        $document = null;

        if ($request->filled('student_id')) {
            $student = Student::with('skripsi.supervisor')->find($request->query('student_id'));
            $skripsi = $student?->skripsi;

            if ($skripsi) {
                $document = SeminarProposalDocument::where('skripsi_id', $skripsi->id)->first();
            }
        }

        return view('seminar_proposal.create', [
            'documentFields' => $this->documentFields,
            'students'       => $students,
            'student'        => $student,
            'skripsi'        => $skripsi,
            'document'       => $document,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ], [
            'student_id.required' => 'Mahasiswa wajib dipilih.',
            'student_id.exists'   => 'Mahasiswa tidak valid.',
        ]);

        $student = Student::with('skripsi')->find($request->student_id);
        $skripsi = $student?->skripsi;

        if (!$skripsi) {
            return back()->withInput()->with('error', 'Mahasiswa ini belum memiliki pengajuan skripsi.');
        }

        $request->validate([
            'bukti_turnitin'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_literasi'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_transkrip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_toefl'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'bukti_turnitin.file'    => 'Bukti Turnitin harus berupa berkas yang valid.',
            'bukti_turnitin.mimes'   => 'Format Bukti Turnitin harus pdf, jpg, jpeg, atau png.',
            'bukti_turnitin.max'     => 'Ukuran Bukti Turnitin maksimal 2MB.',
            'bukti_literasi.file'    => 'Bukti Sertifikat Literasi harus berupa berkas yang valid.',
            'bukti_literasi.mimes'   => 'Format Bukti Sertifikat Literasi harus pdf, jpg, jpeg, atau png.',
            'bukti_literasi.max'     => 'Ukuran Bukti Sertifikat Literasi maksimal 2MB.',
            'bukti_transkrip.file'   => 'Bukti Tanda Tangan Transkrip harus berupa berkas yang valid.',
            'bukti_transkrip.mimes'  => 'Format Bukti Tanda Tangan Transkrip harus pdf, jpg, jpeg, atau png.',
            'bukti_transkrip.max'    => 'Ukuran Bukti Tanda Tangan Transkrip maksimal 2MB.',
            'bukti_toefl.file'       => 'Bukti TOEFL harus berupa berkas yang valid.',
            'bukti_toefl.mimes'      => 'Format Bukti TOEFL harus pdf, jpg, jpeg, atau png.',
            'bukti_toefl.max'        => 'Ukuran Bukti TOEFL maksimal 2MB.',
        ]);

        $document = SeminarProposalDocument::firstOrNew(['skripsi_id' => $skripsi->id]);

        $hasUpload = false;
        foreach (array_keys($this->documentFields) as $field) {
            if ($request->hasFile($field)) {
                // Hapus berkas lama jika sebelumnya sudah pernah diunggah
                if ($document->$field) {
                    Storage::disk('public')->delete($document->$field);
                }
                $document->$field = $request->file($field)->store('attachments', 'public');
                $hasUpload = true;
            }
        }

        if (!$hasUpload) {
            return back()->withInput()->with('error', 'Unggah minimal satu berkas.');
        }

        $document->save();

        return redirect()->route('exam-schedules.index')
            ->with('success', 'Berkas berhasil diunggah.');
    }
}
