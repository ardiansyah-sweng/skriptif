<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\LecturerTopic;


class TopicBoardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $topics = LecturerTopic::with('lecturer')
            ->where('status', 'open')
            ->when($search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('topic_board.index', compact('topics', 'search'));
    }

    public function show($id)
    {
        $topic = LecturerTopic::with('lecturer')->findOrFail($id);
        $students = Student::orderBy('name')->get();
        return view('topic_board.show', compact('topic', 'students'));
    }
}

