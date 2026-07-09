<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Skripsi;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Student::count();

        $skripsiAktif = Skripsi::where('status', 'approved')->count();

        $sudahSidang = Student::whereHas('skripsi.examSchedules', function ($q) {
            $q->where('status', 'selesai');
        })->count();

        $dosen = DB::table('lecturers as l')
            ->leftJoin('skripsi as s', 'l.id', '=', 's.supervisor_id')
            ->leftJoin('exam_schedules as es', function ($join) {
                $join->on('s.id', '=', 'es.skripsi_id')
                     ->where('es.status', '=', 'selesai');
            })
            ->select(
                'l.lecturer_id',
                'l.name',
                'l.email',
                DB::raw('COUNT(DISTINCT s.id) as total_bimbingan'),
                DB::raw('COUNT(DISTINCT CASE WHEN es.status = \'selesai\' THEN s.id END) as sudah_sidang')
            )
            ->groupBy('l.id', 'l.lecturer_id', 'l.name', 'l.email')
            ->orderBy('total_bimbingan', 'desc')
            ->get();

        return view('statistics.index', compact(
            'totalMahasiswa',
            'skripsiAktif',
            'sudahSidang',
            'dosen'
        ));
    }
}
