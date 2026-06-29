<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Lecturer;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index(Skripsi $skripsi)
    {
        $skripsi->load('bimbingans.lecturer');
        $lecturers = Lecturer::all();

        return view('bimbingan.index', compact('skripsi', 'lecturers'));
    }

    public function store(Request $request, Skripsi $skripsi)
    {
        $request->validate([
            'lecturer_id'       => 'required|exists:lecturers,id',
            'tanggal_bimbingan' => 'required|date',
            'catatan'           => 'required|string',
        ], [
            'lecturer_id.required'       => 'Dosen pencatat wajib dipilih.',
            'tanggal_bimbingan.required' => 'Tanggal bimbingan wajib diisi.',
            'catatan.required'           => 'Catatan bimbingan wajib diisi.',
        ]);

        Bimbingan::create([
            'skripsi_id'        => $skripsi->id,
            'lecturer_id'       => $request->lecturer_id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'catatan'           => $request->catatan,
        ]);

        return redirect()
            ->route('bimbingan.index', $skripsi->id)
            ->with('success', 'Catatan bimbingan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->delete();

        return redirect()->back()->with('success', 'Catatan bimbingan berhasil dihapus.');
    }
}
