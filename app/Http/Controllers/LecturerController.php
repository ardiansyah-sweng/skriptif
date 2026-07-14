<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportLecturerRequest;
use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = DB::table('lecturers')->get();
        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('lecturers.create');
    }

    public function printAll()
    {
        $lecturers = DB::table('lecturers')->get();
        return view('lecturers.print', compact('lecturers'));
    }

    public function show($id)
    {
        $lecturer = DB::table('lecturers')->where('id', $id)->first();
        return view('lecturers.show', compact('lecturer'));
    }

    public function edit($id)
    {
        $lecturer = DB::table('lecturers')->where('id', $id)->first();
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
    
    public function import(ImportLecturerRequest $request)
    {
        $path = $request->file('file')->getPathname();

        if (($handle = fopen($path, 'r')) === false) {
            return redirect()->route('lecturers.index')
                ->withErrors(['file' => 'Gagal membaca file CSV.']);
        }

        $header = fgetcsv($handle, 1000, ',');
        if ($header === false) {
            fclose($handle);
            return redirect()->route('lecturers.index')
                ->withErrors(['file' => 'File CSV kosong atau tidak valid.']);
        }

        $header = array_map(fn ($value) => strtolower(trim($value)), $header);
        $requiredHeaders = ['lecturer_id', 'name', 'email', 'expertise', 'max_supervisors'];

        if (array_diff($requiredHeaders, $header)) {
            fclose($handle);
            return redirect()->route('lecturers.index')
                ->withErrors(['file' => 'Header CSV harus berisi: lecturer_id, name, email, expertise, max_supervisors.']);
        }

        $now = now();

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            $row = array_pad($row, count($header), null);
            $data = array_combine($header, $row);

            $lecturerId = trim($data['lecturer_id'] ?? '');
            if ($lecturerId === '') {
                continue;
            }

            DB::table('lecturers')->updateOrInsert(
                ['lecturer_id' => $lecturerId],
                [
                    'name'            => trim($data['name'] ?? ''),
                    'email'           => trim($data['email'] ?? ''),
                    'expertise'       => trim($data['expertise'] ?? '') ?: null,
                    'max_supervisors' => is_numeric($data['max_supervisors']) ? (int) $data['max_supervisors'] : 12,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ]
            );
        }

        fclose($handle);

        return redirect()->route('lecturers.index')
            ->with('success', 'Data dosen berhasil diimpor.');
    }
}
