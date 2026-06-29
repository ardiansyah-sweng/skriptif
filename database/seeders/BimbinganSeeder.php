<?php

namespace Database\Seeders;

use App\Models\Bimbingan;
use App\Models\Skripsi;
use Illuminate\Database\Seeder;

class BimbinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catatanContoh = [
            'Diskusi Bab 1 - Latar Belakang dan rumusan masalah.',
            'Revisi metodologi penelitian dan kerangka teori.',
            'Pembahasan Bab 2 - Tinjauan Pustaka.',
            'Konsultasi instrumen penelitian dan kuesioner.',
            'Review Bab 3 - Metodologi Penelitian.',
            'Pembahasan hasil pengumpulan data lapangan.',
            'Bimbingan analisis data dan interpretasi hasil.',
            'Review draft Bab 4 - Hasil dan Pembahasan.',
            'Koreksi penulisan dan format sitasi.',
            'Persiapan seminar hasil penelitian.',
        ];

        $allSkripsi = Skripsi::all();

        foreach ($allSkripsi as $skripsi) {
            if (is_null($skripsi->supervisor_id)) {
                continue;
            }

            $jumlahSesi = rand(2, 3);
            $catatanAcak = array_slice(
                array_keys(array_flip($catatanContoh)),
                0,
                $jumlahSesi
            );

            // Pilih catatan yang tidak berulang untuk tiap skripsi
            $indeksCatatan = array_rand($catatanContoh, $jumlahSesi);
            if (!is_array($indeksCatatan)) {
                $indeksCatatan = [$indeksCatatan];
            }

            foreach ($indeksCatatan as $urutan => $indeks) {
                Bimbingan::create([
                    'skripsi_id'        => $skripsi->id,
                    'lecturer_id'       => $skripsi->supervisor_id,
                    'tanggal_bimbingan' => now()->subWeeks($jumlahSesi - $urutan)->format('Y-m-d'),
                    'catatan'           => $catatanContoh[$indeks],
                ]);
            }
        }
    }
}
