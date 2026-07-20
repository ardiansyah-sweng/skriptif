<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Models\Evaluation;
use App\Models\EvaluationComponent;
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

        // Rekap per skripsi: gabungkan nilai Pembimbing (50%) + Penguji (50%)
        // menjadi Total Nilai Semprog, sesuai format rekap penilaian.
        $rekap = $evaluations
            ->groupBy('skripsi_id')
            ->map(function ($group) {
                $pembimbing = $group->firstWhere('role', 'pembimbing');
                $penguji = $group->firstWhere('role', 'penguji');

                return [
                    'skripsi' => $group->first()->skripsi,
                    'pembimbing' => $pembimbing,
                    'penguji' => $penguji,
                    'total' => round(
                        (float) ($pembimbing->final_score ?? 0) + (float) ($penguji->final_score ?? 0),
                        2
                    ),
                ];
            })
            ->values();

        return view('evaluations.index', compact('evaluations', 'rekap'));
    }

    public function create()
    {
        $skripsiList = Skripsi::with('student')
            ->where('status', 'approved')
            ->get();

        $lecturers = Lecturer::orderBy('name')->get();

        // Dua rubrik komponen penilaian sekaligus, dikirim ke view supaya
        // form bisa menampilkan 2 list dosen + 2 set unsur penilaian
        // (Pembimbing / Penguji) dan menampilkan yang relevan lewat JS.
        $components = [
            'pembimbing' => EvaluationComponent::forRole('pembimbing')->get(),
            'penguji' => EvaluationComponent::forRole('penguji')->get(),
        ];

        return view('evaluations.create', compact('skripsiList', 'lecturers', 'components'));
    }

    public function store(EvaluationRequest $request)
    {
        $validated = $request->validated();

        $evaluation = Evaluation::create([
            'skripsi_id' => $validated['skripsi_id'],
            'lecturer_id' => $validated['lecturer_id'],
            'role' => $validated['role'],
            'weight' => $validated['weight'] ?? 50,
            'score' => 0, // dihitung ulang oleh syncComponentScores()
            'notes' => $validated['notes'] ?? null,
            'evaluation_date' => $validated['evaluation_date'],
        ]);

        $evaluation->syncComponentScores($validated['components']);

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil disimpan.');
    }

    public function show(string $id)
    {
        $evaluation = Evaluation::with(['skripsi.student', 'lecturer', 'componentScores.component'])
            ->findOrFail($id);

        // Evaluasi pasangannya (kalau peran Pembimbing, cari Penguji, atau sebaliknya)
        // untuk menampilkan Total Nilai Semprog di halaman detail.
        $counterpart = Evaluation::where('skripsi_id', $evaluation->skripsi_id)
            ->where('role', $evaluation->role === 'pembimbing' ? 'penguji' : 'pembimbing')
            ->first();

        return view('evaluations.show', compact('evaluation', 'counterpart'));
    }

    public function edit(string $id)
    {
        $evaluation = Evaluation::with('componentScores')->findOrFail($id);
        $skripsiList = Skripsi::with('student')->where('status', 'approved')->get();
        $lecturers = Lecturer::orderBy('name')->get();

        $components = [
            'pembimbing' => EvaluationComponent::forRole('pembimbing')->get(),
            'penguji' => EvaluationComponent::forRole('penguji')->get(),
        ];

        // Nilai unsur yang sudah tersimpan, dikelompokkan per component_id,
        // supaya form edit bisa langsung terisi (old value).
        $existingScores = $evaluation->componentScores->pluck('score', 'evaluation_component_id');

        return view('evaluations.edit', compact(
            'evaluation',
            'skripsiList',
            'lecturers',
            'components',
            'existingScores'
        ));
    }

    public function update(EvaluationRequest $request, string $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $validated = $request->validated();

        $evaluation->update([
            'skripsi_id' => $validated['skripsi_id'],
            'lecturer_id' => $validated['lecturer_id'],
            'role' => $validated['role'],
            'weight' => $validated['weight'] ?? 50,
            'notes' => $validated['notes'] ?? null,
            'evaluation_date' => $validated['evaluation_date'],
        ]);

        $evaluation->syncComponentScores($validated['components']);

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