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
            'student_id' => 'required|exists:students,id',
            'message' => 'nullable|string|max:1000',
        ], [
            'student_id.required' => 'Pilih mahasiswa terlebih dahulu.',
            'student_id.exists' => 'Mahasiswa tidak ditemukan.',
        ]);
        $student = Student::findOrFail($validated['student_id']);
        $existing = TopicApplication::where('lecturer_topic_id', $topic->id)
            ->where('student_id', $student->id)
            ->first();
        if ($existing) {
            return redirect()->route('topic-board.show', $topic->id)
                ->with('error', 'Anda sudah mengajukan topik ini.');
        }

        TopicApplication::create([
            'lecturer_topic_id' => $topic->id,
            'student_id' => $student->id,
            'applicant_name' => $student->name,
            'applicant_nim' => $student->student_id,
            'message' => $validated['message'] ?? null,
        ]);
        $topic->update(['status' => 'closed']);
        return redirect()->route('topic-board.show', $topic->id)
            ->with('success', 'Pengajuan topik berhasil dikirim.');
    }

    
    public function approve(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $application->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Aplikasi disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $application->update(['status' => 'rejected']);
        $application->lecturerTopic->update(['status' => 'open']);
        return redirect()->back()->with('success', 'Aplikasi ditolak. Topik kembali dibuka.');
    }

    public function destroy(Request $request, $id)
    {
        $application = TopicApplication::with('lecturerTopic')->findOrFail($id);
        $application->delete();
        return redirect()->back()->with('success', 'Aplikasi mahasiswa berhasil dihapus.');
    }
}