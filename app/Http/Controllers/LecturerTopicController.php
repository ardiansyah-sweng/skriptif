<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\LecturerTopic;

class LecturerTopicController extends Controller
{
    public function index()
    {
        $topics = LecturerTopic::with('lecturer')->latest()->get();
        return view('lecturer_topics.index', compact('topics'));
    }

    public function create()
    {
        $lecturers = Lecturer::all();
        return view('lecturer_topics.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'requirements' => 'nullable|string|max:1000',
            'deadline' => 'nullable|date',
            'capacity' => 'nullable|integer|min:1|max:50',
            'attachment' => 'nullable|url',
        ], [
            'lecturer_id.required' => 'Dosen harus dipilih.',
            'lecturer_id.exists' => 'Dosen tidak ditemukan.',
            'title.required' => 'Judul topik wajib diisi.',
            'description.required' => 'Deskripsi topik wajib diisi.',
        ]);

        $validated['capacity'] = $validated['capacity'] ?? 1;
        $validated['status'] = 'open';
        $validated['applied_count'] = 0;

        LecturerTopic::create($validated);

        return redirect()->route('lecturer-topics.index')->with('success', 'Topik dosen berhasil dibuat.');
    }

    public function show($id)
    {
        $topic = LecturerTopic::with(['lecturer', 'applications.student'])->findOrFail($id);
        return view('lecturer_topics.show', compact('topic'));
    }

    public function edit($id)
    {
        $topic = LecturerTopic::findOrFail($id);
        $lecturers = Lecturer::all();
        return view('lecturer_topics.edit', compact('topic', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        $topic = LecturerTopic::findOrFail($id);

        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'requirements' => 'nullable|string|max:1000',
            'deadline' => 'nullable|date',
            'capacity' => 'required|integer|min:1|max:50',
            'attachment' => 'nullable|url',
            'status' => 'required|in:open,closed,filled',
        ]);

        $topic->update($validated);

        return redirect()->route('lecturer-topics.show', $topic->id)->with('success', 'Topik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $topic = LecturerTopic::findOrFail($id);
        $topic->delete();
        return redirect()->route('lecturer-topics.index')->with('success', 'Topik berhasil dihapus.');
    }
}