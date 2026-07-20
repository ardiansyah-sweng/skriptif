<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentSkripsiRequest;
use App\Models\Lecturer;
use App\Models\Skripsi;
use App\Models\ElectiveCourse;
use App\Models\Student;
use App\Notifications\NewSkripsiSubmitted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentSkripsiController extends Controller
{
    /**
     * Ambil data Student milik akun yang sedang login (bukan sembarang mahasiswa).
     * Pakai relasi user_id dulu; kalau belum tertaut (data lama), fallback ke email
     * lalu tautkan otomatis biar berikutnya lewat relasi langsung.
     */
    private function resolveAuthenticatedStudent()
    {
        $user = Auth::user();

        if ($user->student) {
            return $user->student;
        }

        $student = Student::where('email', $user->email)->first();
        if ($student) {
            $student->update(['user_id' => $user->id]);
        }

        return $student;
    }

    public function create()
    {
        $student = $this->resolveAuthenticatedStudent();
        if (!$student) {
            return redirect()->back()->with('error', 'Data mahasiswa untuk akun ini tidak ditemukan.');
        }

        $lecturers = Lecturer::all();
        $electiveCourses = ElectiveCourse::all();

        $lecturersWithCapacity = $lecturers->map(function ($lecturer) use ($student) {
            $approvedCount = Skripsi::where('supervisor_id', $lecturer->id)
                ->where('status', 'approved')
                ->whereHas('student', function ($q) use ($student) {
                    $q->where('year_entrance', $student->year_entrance);
                })
                ->count();

            $maxCapacity = $lecturer->max_supervisors ?? 3;
            $remainingCapacity = max(0, $maxCapacity - $approvedCount);

            return [
                'id'                  => $lecturer->id,
                'name'                => $lecturer->name,
                'max_supervisors'     => $maxCapacity,
                'approved_count'      => $approvedCount,
                'remaining_capacity'  => $remainingCapacity,
                'is_available'        => $remainingCapacity > 0,
            ];
        });

        return view('mahasiswa.skripsi.create', compact('lecturersWithCapacity', 'electiveCourses'));
    }

 public function store(StoreStudentSkripsiRequest $request)
{
    $student = $this->resolveAuthenticatedStudent();

    if (!$student) {
        return redirect()->back()->with('error', 'Data mahasiswa untuk akun ini tidak ditemukan.');
    }

    $lecturer = Lecturer::find($request->supervisor_id);
    if (!$lecturer) {
        return back()->with('error', 'Dosen pembimbing tidak valid.');
    }

    $studentYearEntrance = $student->year_entrance;

    $approvedSupervisorCount = Skripsi::where('supervisor_id', $lecturer->id)
        ->where('status', 'approved')
        ->whereHas('student', function ($q) use ($studentYearEntrance) {
            $q->where('year_entrance', $studentYearEntrance);
        })
        ->count();

    if ($approvedSupervisorCount >= (int) ($lecturer->max_supervisors ?? 3)) {
        return back()->withErrors([
            'supervisor_id' => 'Dosen pembimbing ini sudah mencapai batas maksimal mahasiswa dari angkatan ' . $studentYearEntrance . '.'
        ])->withInput();
    }

    $electiveData = [];
    if ($request->has('elective_courses')) {
        foreach ($request->elective_courses as $item) {
            if (!empty($item['id'] ?? null)) {
                $electiveData[] = [
                    'id'    => (int) $item['id'],
                    'grade' => $item['grade'] ?? null,
                ];
            }
        }
    }

    try {
        $skripsi = Skripsi::create([
            'student_id'            => $student->id,
            'supervisor_id'         => $request->supervisor_id,
            'title'                 => $request->title,
            'description'           => $request->description,
            'suggestion_supervisor' => $request->suggestion_supervisor,
            'elective_courses'      => $electiveData,
            'status'                => 'pending',
            'submission_date'       => now(),
        ]);

        // Kirim notifikasi ke dosen pembimbing yang dipilih di form
        $skripsi->load(['student', 'supervisor']);
        if ($account = $skripsi->supervisor->account()) {
            $account->notify(new NewSkripsiSubmitted($skripsi));
        } else {
            Log::warning('Notifikasi pengajuan skripsi baru gagal dikirim: tidak ada User dengan email ' . $skripsi->supervisor->email);
        }

        return redirect()
            ->route('student.skripsi.history')
            ->with('success', 'Pengajuan berhasil!');

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
}

    public function history()
    {
        $student = $this->resolveAuthenticatedStudent();
        $skripsis = $student
            ? Skripsi::where('student_id', $student->id)->with('supervisor')->latest()->get()
            : collect();

        return view('mahasiswa.skripsi.submissions', compact('skripsis'));
    }
}