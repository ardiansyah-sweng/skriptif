<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = DB::table('lecturers')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lecturers.index', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lecturer_id' => 'required|string|max:20|unique:lecturers,lecturer_id',
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:lecturers,email',
            'expertise'   => 'nullable|string|max:150',
        ]);

        DB::table('lecturers')->insert([
            'lecturer_id' => $request->lecturer_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'expertise'   => $request->expertise,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $lecturer = DB::table('lecturers')->where('id', $id)->first();

        if (!$lecturer) {
            abort(404);
        }

        DB::table('lecturers')->where('id', $id)->delete();

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}
