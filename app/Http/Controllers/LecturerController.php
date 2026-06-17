<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecturer::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $lecturers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('lecturers.index', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lecturer_id' => 'required|string|max:20|unique:lecturers,lecturer_id',
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:lecturers,email',
            'expertise'   => 'nullable|string|max:150',
            'status'      => 'required|in:active,inactive',
        ]);

        Lecturer::create($request->all());

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        return view('lecturers.show', compact('lecturer'));
    }

    public function edit($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        return view('lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        $request->validate([
            'lecturer_id' => 'required|string|max:20|unique:lecturers,lecturer_id,' . $lecturer->id,
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:lecturers,email,' . $lecturer->id,
            'expertise'   => 'nullable|string|max:150',
            'status'      => 'required|in:active,inactive',
        ]);

        $lecturer->update($request->all());

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $lecturer->delete();

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}
