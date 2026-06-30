<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    

    public function store(Request $request)
    {
        $request->validate([
            'lecturer_id' => 'required|string|max:255|unique:lecturers,lecturer_id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:lecturers,email',
            'expertise'   => 'nullable|string|max:255',
        ]);

        DB::table('lecturers')->insert([
            'lecturer_id' => $request->lecturer_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'expertise'   => $request->expertise,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect('/');
    }

    public function destroy($id)
    {
        DB::table('lecturers')->where('id', $id)->delete();
        return redirect('/');
    }
}