<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Skripsi;

class ExamScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil skripsi milik Ricky yang berstatus 'approved'
        $skripsiApproved = Skripsi::where('status', 'approved')
            ->where('title', 'like', 'Analisis Forensik%')
            ->first();

        if (!$skripsiApproved) {
            return;
        }

        DB::table('exam_schedules')->insert([
            [
                'skripsi_id'     => $skripsiApproved->id,
                'jenis_sidang'   => 'proposal',
                'tanggal_sidang' => now()->addWeek()->toDateString(),
                'jam_mulai'      => '09:00:00',
                'jam_selesai'    => '10:00:00',
                'ruang'          => 'R. Sidang A',
                'status'         => 'terjadwal',
                'catatan'        => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'skripsi_id'     => $skripsiApproved->id,
                'jenis_sidang'   => 'hasil',
                'tanggal_sidang' => now()->addWeeks(2)->toDateString(),
                'jam_mulai'      => '10:00:00',
                'jam_selesai'    => '11:00:00',
                'ruang'          => 'R. Sidang B',
                'status'         => 'terjadwal',
                'catatan'        => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
