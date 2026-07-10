<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = DB::table('lecturers')->get();
        return view('lecturers.index', compact('lecturers'));
    }

    public function printAll()
    {
        $lecturers = DB::table('lecturers')->get();
        return view('lecturers.print', compact('lecturers'));
    }

    public function show($id)
    {
        $lecturer = DB::table('lecturers')
            ->where('id', $id)
            ->first();

        abort_if(!$lecturer, 404);

        return view('lecturers.show', compact('lecturer'));
    }

    public function edit($id)
    {
        $lecturer = DB::table('lecturers')
            ->where('id', $id)
            ->first();

        abort_if(!$lecturer, 404);

        return view('lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lecturer_id' => 'required|string|max:255|unique:lecturers,lecturer_id,' . $id,
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:lecturers,email,' . $id,
            'expertise'   => 'nullable|string|max:255',
            'max_supervisors' => 'required|integer|min:1',
        ], [
            'max_supervisors.required' => 'Batas dosen pembimbing wajib diisi.',
            'max_supervisors.integer' => 'Batas dosen pembimbing harus angka.',
            'max_supervisors.min' => 'Batas dosen pembimbing minimal 1.',
        ]);

        DB::table('lecturers')->where('id', $id)->update([
            'lecturer_id' => $request->lecturer_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'expertise'   => $request->expertise,
            'max_supervisors' => (int) $request->max_supervisors,
            'updated_at'  => now(),
        ]);

        return redirect()->route('lecturers.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lecturer_id' => 'required|string|max:255|unique:lecturers,lecturer_id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:lecturers,email',
            'expertise'   => 'nullable|string|max:255',
            'max_supervisors' => 'required|integer|min:1',
        ], [
            'max_supervisors.required' => 'Batas dosen pembimbing wajib diisi.',
            'max_supervisors.integer' => 'Batas dosen pembimbing harus angka.',
            'max_supervisors.min' => 'Batas dosen pembimbing minimal 1.',
        ]);

        DB::table('lecturers')->insert([
            'lecturer_id' => $request->lecturer_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'expertise'   => $request->expertise,
            'max_supervisors' => (int) $request->max_supervisors,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('lecturers.index');
    }

    public function destroy($id)
    {
        DB::table('lecturers')->where('id', $id)->delete();
        return redirect()->route('lecturers.index');
    }
}