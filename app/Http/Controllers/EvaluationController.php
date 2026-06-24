<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Skripsi;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['skripsi', 'evaluator'])->get();
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $skripsis = Skripsi::all();
        $lecturers = Lecturer::all();
        return view('evaluations.create', compact('skripsis', 'lecturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skripsi_id' => 'required|exists:skripsi,id',
            'evaluator_id' => 'required|exists:lecturers,id',
            'evaluation_type' => 'required|string|max:255',
            'overall_score' => 'required|integer|min:0|max:100',
            'grade_letter' => 'nullable|string|max:2',
            'revision_notes' => 'nullable|string',
            'status' => 'required|in:passed,needs_revision,failed',
            'evaluation_date' => 'required|date',
        ]);

        Evaluation::create($validated);

        return redirect()->route('evaluations.index')->with('success', 'Evaluation added successfully!');
    }

}