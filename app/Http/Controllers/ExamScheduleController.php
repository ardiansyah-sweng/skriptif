<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $schedules = ExamSchedule::with(['skripsi.student', 'skripsi.supervisor'])
            ->latest('tanggal_sidang')
            ->get();

        return view('exam_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $approvedSkripsi = Skripsi::where('status', 'approved')
            ->with('student')
            ->get();

        return view('exam_schedules.create', compact('approvedSkripsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skripsi_id'     => 'required|exists:skripsi,id',
            'jenis_sidang'   => 'required|in:proposal,hasil,pendadaran',
            'tanggal_sidang' => 'required|date|after_or_equal:today',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'ruang'          => 'required|string|max:100',
            'catatan'        => 'nullable|string',
        ], [
            'skripsi_id.required'          => 'Skripsi wajib dipilih.',
            'skripsi_id.exists'            => 'Skripsi tidak valid.',
            'jenis_sidang.required'        => 'Jenis sidang wajib dipilih.',
            'jenis_sidang.in'              => 'Jenis sidang tidak valid.',
            'tanggal_sidang.required'      => 'Tanggal sidang wajib diisi.',
            'tanggal_sidang.after_or_equal'=> 'Tanggal sidang tidak boleh di masa lalu.',
            'jam_mulai.required'           => 'Jam mulai wajib diisi.',
            'jam_selesai.required'         => 'Jam selesai wajib diisi.',
            'jam_selesai.after'            => 'Jam selesai harus setelah jam mulai.',
            'ruang.required'               => 'Ruang sidang wajib diisi.',
        ]);

        // Defense in depth: cek ulang status skripsi di controller
        $skripsi = Skripsi::findOrFail($request->skripsi_id);
        if ($skripsi->status !== 'approved') {
            return back()->withErrors(['skripsi_id' => 'Hanya skripsi yang sudah disetujui yang dapat dijadwalkan.']);
        }

        ExamSchedule::create($request->only([
            'skripsi_id',
            'jenis_sidang',
            'tanggal_sidang',
            'jam_mulai',
            'jam_selesai',
            'ruang',
            'catatan',
        ]));

        return redirect()->route('exam-schedules.index')
            ->with('success', 'Jadwal sidang berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()
            ->with('success', 'Jadwal sidang berhasil dihapus.');
    }
}
