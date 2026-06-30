<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Skripsi;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::with(['skripsi', 'evaluator'])->get();
        return view('logbooks.index', compact('logbooks'));
    }

    public function create()
    {
        $skripsis = Skripsi::all();
        $lecturers = Lecturer::all();
        return view('logbooks.create', compact('skripsis', 'lecturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skripsi_id' => 'required|exists:skripsi,id',
            'evaluator_id' => 'required|exists:lecturers,id',
            'logbook_type' => 'required|string|max:255',
            'overall_score' => 'required|integer|min:0|max:100',
            'grade_letter' => 'nullable|string|max:2',
            'revision_notes' => 'nullable|string',
            'status' => 'required|in:passed,needs_revision,failed',
            'logbook_date' => 'required|date',
        ]);

        Logbook::create($validated);

        return redirect()->route('logbooks.index')->with('success', 'Logbook added successfully!');
    }

}