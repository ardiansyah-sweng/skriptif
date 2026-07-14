<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Models\Evaluation;
use App\Models\Lecturer;
use App\Models\Skripsi;

class EvaluationController extends Controller
{
    /**
     * Daftar semua evaluasi.
     * Catatan: karena belum ada login, index ini menampilkan semua data.
     * Nanti kalau login mahasiswa sudah ada, filter dengan
     * ->where('skripsi_id', auth()->user()->skripsi->id) supaya mahasiswa
     * hanya lihat evaluasi miliknya sendiri.
     */
    public function index()
    {
        $evaluations = Evaluation::with(['skripsi.student', 'lecturer'])
            ->latest('evaluation_date')
            ->get();

        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $skripsiList = Skripsi::with('student')
            ->where('status', 'approved')
            ->get();

        $lecturers = Lecturer::orderBy('name')->get();

        return view('evaluations.create', compact('skripsiList', 'lecturers'));
    }

    public function store(EvaluationRequest $request)
    {
        Evaluation::create($request->validated());

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil disimpan.');
    }

    public function show(string $id)
    {
        $evaluation = Evaluation::with(['skripsi.student', 'lecturer'])->findOrFail($id);

        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(string $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $skripsiList = Skripsi::with('student')->where('status', 'approved')->get();
        $lecturers = Lecturer::orderBy('name')->get();

        return view('evaluations.edit', compact('evaluation', 'skripsiList', 'lecturers'));
    }

    public function update(EvaluationRequest $request, string $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($request->validated());

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Evaluation::findOrFail($id)->delete();

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil dihapus.');
    }
}