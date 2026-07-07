<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\LecturerTopic;
use App\Models\TopicApplication;
use App\Models\Student;

class TopicApplicationController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->query('student_id');
        $applications = TopicApplication::with(['student', 'lecturerTopic.lecturer'])
            ->when($studentId, function ($query, $studentId) {
                return $query->where('student_id', $studentId);
            })
            ->latest()
            ->get();

        return view('topic_applications.index', compact('applications', 'studentId'));
    }

    public function store(Request $request, $topicId)
    {
        $topic = LecturerTopic::findOrFail($topicId);

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_nim' => 'required|string|max:100',
            'document' => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
            'requirements_note' => 'required|string|max:1000',
            'message' => 'nullable|string|max:1000',
        ], [
            'applicant_name.required' => 'Nama mahasiswa wajib diisi.',
            'applicant_nim.required' => 'NIM mahasiswa wajib diisi.',
            'document.required' => 'Dokumen aplikasi wajib dilampirkan.',
            'document.mimes' => 'Dokumen harus berupa PDF, DOC, DOCX, atau ZIP.',
            'document.max' => 'Ukuran dokumen maksimal 10MB.',
            'requirements_note.required' => 'Keterangan persyaratan wajib diisi.',
        ]);

        $existing = TopicApplication::where('lecturer_topic_id', $topic->id)
            ->where('applicant_nim', $validated['applicant_nim'])
            ->first();

        if ($existing) {
            return redirect()->route('topic-board.show', $topic->id)
                ->with('error', 'Anda sudah mengajukan topik ini dengan NIM yang sama.');
        }

        $path = $request->file('document')->store('topic_applications', 'public');

        TopicApplication::create([
            'lecturer_topic_id' => $topic->id,
            'applicant_name' => $validated['applicant_name'],
            'applicant_nim' => $validated['applicant_nim'],
            'document_path' => $path,
            'requirements_note' => $validated['requirements_note'],
            'message' => $validated['message'] ?? null,
        ]);

        $topic->increment('applied_count');
        if ($topic->applied_count >= $topic->capacity) {
            $topic->update(['status' => 'filled']);
        }

        return redirect()->route('topic-board.show', $topic->id)
            ->with('success', 'Pengajuan topik berhasil dikirim.');
    }

    /**
     * Approve an application (set status = approved)
     */
    public function approve(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $application->update(['status' => 'approved']);

        $topic = $application->lecturerTopic;
        // jika kapasitas terpenuhi, set status filled
        if ($topic->applied_count >= $topic->capacity) {
            $topic->update(['status' => 'filled']);
        }

        return redirect()->back()->with('success', 'Aplikasi disetujui.');
    }

    /**
     * Reject an application (set status = rejected) and decrement applied_count
     */
    public function reject(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $application->update(['status' => 'rejected']);

        $topic = $application->lecturerTopic;
        if ($topic->applied_count > 0) {
            $topic->decrement('applied_count');
        }

        // jika sebelumnya filled dan sekarang ada ruang, buka kembali
        if ($topic->status === 'filled' && $topic->applied_count < $topic->capacity) {
            $topic->update(['status' => 'open']);
        }

        return redirect()->back()->with('success', 'Aplikasi ditolak.');
    }

    /**
     * Destroy (delete) an application. Decrements counts and re-opens topic if needed.
     */
    public function destroy(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);

        $topic = $application->lecturerTopic;

        // If application was counted towards applied_count, decrement
        if (in_array($application->status, ['pending', 'approved'])) {
            if ($topic->applied_count > 0) {
                $topic->decrement('applied_count');
            }
        }

        // If topic was filled and now has space, set to open
        if ($topic->status === 'filled' && $topic->applied_count < $topic->capacity) {
            $topic->update(['status' => 'open']);
        }

        $application->delete();

        return redirect()->back()->with('success', 'Aplikasi mahasiswa berhasil dihapus.');
    }
}
