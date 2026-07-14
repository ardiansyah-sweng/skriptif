<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamSchedule::with(['skripsi.student', 'skripsi.supervisor']);

        if ($request->filled('nama')) {
            $query->whereHas('skripsi.student', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->nama}%");
            });
        }

        if ($request->filled('nim')) {
            $query->whereHas('skripsi.student', function ($q) use ($request) {
                $q->where('student_id', 'like', "%{$request->nim}%");
            });
        }

        if ($request->filled('dosen_penguji')) {
            $query->whereHas('skripsi.supervisor', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->dosen_penguji}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal_sidang', $request->tanggal);
        }

        if ($request->filled('ruang')) {
            $query->where('ruang', 'like', "%{$request->ruang}%");
        }

        $schedules = $query->latest('tanggal_sidang')->get();

        return view('exam_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $approvedSkripsi = Skripsi::where('status', 'approved')
            ->whereHas('student', function ($query) {
                $query->where('is_lulus', false);
            })
            ->whereDoesntHave('examSchedules', function ($query) {
                $query->where('jenis_sidang', 'pendadaran');
            })
            ->with('student')
            ->get();

        return view('exam_schedules.create', compact('approvedSkripsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skripsi_id'     => 'required|exists:skripsi,id',
            'jenis_sidang'   => [
                'required',
                'in:proposal,pendadaran',
                Rule::unique('exam_schedules')->where(function ($query) use ($request) {
                    return $query->where('skripsi_id', $request->skripsi_id);
                }),
            ],
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
            'jenis_sidang.unique'          => 'Mahasiswa sudah menjadwalkan sidang jenis ini.',
            'tanggal_sidang.required'      => 'Tanggal sidang wajib diisi.',
            'tanggal_sidang.after_or_equal'=> 'Tanggal sidang tidak boleh di masa lalu.',
            'jam_mulai.required'           => 'Jam mulai wajib diisi.',
            'jam_selesai.required'         => 'Jam selesai wajib diisi.',
            'jam_selesai.after'            => 'Jam selesai harus setelah jam mulai.',
            'ruang.required'               => 'Ruang sidang wajib diisi.',
        ]);

        $skripsi = Skripsi::with('student')->findOrFail($request->skripsi_id);
        if ($skripsi->status !== 'approved') {
            return back()->withErrors(['skripsi_id' => 'Hanya skripsi yang sudah disetujui yang dapat dijadwalkan.']);
        }

        if ($skripsi->student && $skripsi->student->is_lulus) {
            return back()->withErrors(['skripsi_id' => 'Mahasiswa ini sudah lulus dan tidak dapat dijadwalkan lagi.']);
        }

        if (ExamSchedule::where('skripsi_id', $skripsi->id)->where('jenis_sidang', 'pendadaran')->exists()) {
            return back()->withErrors(['skripsi_id' => 'Mahasiswa ini sudah memiliki jadwal sidang pendadaran.']);
        }

        if ($request->jenis_sidang === 'pendadaran') {
            $proposalExam = ExamSchedule::where('skripsi_id', $skripsi->id)
                ->where('jenis_sidang', 'proposal')
                ->first();

            if (!$proposalExam) {
                return back()->withErrors(['jenis_sidang' => 'Mahasiswa harus menyelesaikan sidang proposal terlebih dahulu sebelum dapat dijadwalkan untuk pendadaran.'])->withInput();
            }

            if (strtotime($request->tanggal_sidang) < strtotime($proposalExam->tanggal_sidang)) {
                return back()->withErrors(['tanggal_sidang' => 'Tanggal sidang pendadaran tidak boleh mendahului tanggal sidang proposal (' . \Carbon\Carbon::parse($proposalExam->tanggal_sidang)->format('d-m-Y') . ').'])->withInput();
            }
        }

        $overlapCount = ExamSchedule::where('ruang', $request->ruang)
            ->where('tanggal_sidang', $request->tanggal_sidang)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->count();

        if ($overlapCount > 0) {
            return back()->withErrors(['ruang' => 'Ruangan sudah terpakai pada waktu tersebut.'])->withInput();
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

    public function show($id)
    {
        $schedule = ExamSchedule::with(['skripsi.student', 'skripsi.supervisor'])
            ->findOrFail($id);

        return view('exam_schedules.show', compact('schedule'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['terjadwal', 'selesai', 'dibatalkan'])],
        ], [
            'status.required' => 'Status jadwal wajib dipilih.',
            'status.in'       => 'Status jadwal tidak valid.',
        ]);

        $schedule = ExamSchedule::findOrFail($id);
        $schedule->update($validated);

        return redirect()->route('exam-schedules.show', $schedule->id)
            ->with('success', 'Status jadwal sidang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);

        if ($schedule->jenis_sidang === 'proposal') {
            $hasPendadaran = ExamSchedule::where('skripsi_id', $schedule->skripsi_id)
                ->where('jenis_sidang', 'pendadaran')
                ->exists();

            if ($hasPendadaran) {
                return redirect()->back()->withErrors(['error' => 'Tidak dapat menghapus jadwal proposal karena mahasiswa sudah memiliki jadwal pendadaran. Hapus jadwal pendadaran terlebih dahulu.']);
            }
        }

        $schedule->delete();

        return redirect()->back()
            ->with('success', 'Jadwal sidang berhasil dihapus.');
    }
}
