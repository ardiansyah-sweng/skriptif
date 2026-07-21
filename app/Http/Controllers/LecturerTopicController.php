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
        $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'titles' => 'required|array|min:1',
            'titles.*' => 'required|string|max:255',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string|min:10',
            'deadlines' => 'nullable|array',
            'deadlines.*' => 'nullable|date',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:1000',
            'capacities' => 'nullable|array',
            'capacities.*' => 'nullable|integer|min:1|max:999',
        ], [
            'lecturer_id.required' => 'Dosen harus dipilih.',
            'lecturer_id.exists' => 'Dosen tidak ditemukan.',
            'titles.required' => 'Minimal satu judul topik wajib diisi.',
            'titles.*.required' => 'Setiap judul topik wajib diisi.',
            'descriptions.*.required' => 'Setiap deskripsi topik wajib diisi.',
            'descriptions.*.min' => 'Deskripsi topik minimal 10 karakter.',
            'capacities.*.integer' => 'Kapasitas harus berupa angka.',
            'capacities.*.min' => 'Kapasitas minimal 1.',
        ]);
        $lecturerId = $request->lecturer_id;
        $titles = $request->titles;
        $descriptions = $request->descriptions;
        $deadlines = $request->deadlines ?? [];
        $requirements = $request->requirements ?? [];
        $capacities = $request->capacities ?? [];

        foreach ($titles as $i => $title) {
            LecturerTopic::create([
                'lecturer_id' => $lecturerId,
                'title' => $title,
                'description' => $descriptions[$i] ?? '',
                'requirements' => $requirements[$i] ?? null,
                'capacity' => $capacities[$i] ?? 1,
                'deadline' => $deadlines[$i] ?? null,
                'status' => 'open',
            ]);
        }

        $count = count($titles);
        return redirect()->route('lecturer-topics.index')->with('success', "{$count} topik dosen berhasil dibuat.");
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
            'capacity' => 'nullable|integer|min:1|max:999',
            'deadline' => 'nullable|date',
            'attachment' => 'nullable|string|max:255',
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