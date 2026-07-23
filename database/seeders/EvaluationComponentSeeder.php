<?php

namespace Database\Seeders;

use App\Models\EvaluationComponent;
use Illuminate\Database\Seeder;

class EvaluationComponentSeeder extends Seeder
{
    /**
     * Rubrik diambil dari format penilaian seminar proposal:
     * - Dosen Pembimbing punya 8 unsur (termasuk "Pembimbingan/checklist berkas")
     * - Dosen Penguji punya 7 unsur (tanpa unsur pembimbingan, rentang nilai
     *   sedikit berbeda pada unsur ke-2 & ke-3 untuk menutup total 100)
     */
    public function run(): void
    {
        $pembimbing = [
            ['name' => 'Pembimbingan (checklist berkas)', 'min_score' => 0, 'max_score' => 10, 'order' => 1],
            ['name' => 'Abstrak Proposal', 'min_score' => 0, 'max_score' => 5, 'order' => 2],
            ['name' => 'Keterkaitan: latar belakang masalah, batasan masalah, rumusan masalah, tujuan penelitian, dan manfaat penelitian', 'min_score' => 0, 'max_score' => 20, 'order' => 3],
            ['name' => 'Pemahaman terhadap metode/algoritma yang digunakan', 'min_score' => 0, 'max_score' => 20, 'order' => 4],
            ['name' => 'Kelengkapan dan Pemahaman Landasan Teori', 'min_score' => 0, 'max_score' => 20, 'order' => 5],
            ['name' => 'Kejelasan Metodologi Penelitian', 'min_score' => 0, 'max_score' => 10, 'order' => 6],
            ['name' => 'Kebaruan Pustaka/Referensi', 'min_score' => 0, 'max_score' => 10, 'order' => 7],
            ['name' => 'Rancangan Arsitektur Sistem/ Struktur Menu/ Antarmuka/ Prototype/ Struktur Collecting Data (untuk analisis forensic)', 'min_score' => 0, 'max_score' => 5, 'order' => 8],
        ];

        $penguji = [
            ['name' => 'Abstrak Proposal', 'min_score' => 0, 'max_score' => 5, 'order' => 1],
            ['name' => 'Keterkaitan: latar belakang masalah, batasan masalah, rumusan masalah, tujuan penelitian, dan manfaat penelitian', 'min_score' => 0, 'max_score' => 25, 'order' => 2],
            ['name' => 'Pemahaman terhadap metode/algoritma yang digunakan', 'min_score' => 0, 'max_score' => 25, 'order' => 3],
            ['name' => 'Kelengkapan dan Pemahaman Landasan Teori', 'min_score' => 0, 'max_score' => 20, 'order' => 4],
            ['name' => 'Kejelasan Metodologi Penelitian', 'min_score' => 0, 'max_score' => 10, 'order' => 5],
            ['name' => 'Kebaruan Pustaka/Referensi', 'min_score' => 0, 'max_score' => 10, 'order' => 6],
            ['name' => 'Rancangan Arsitektur Sistem/ Struktur Menu/ Antarmuka/ Prototype/ Struktur Collecting Data (untuk analisis forensic)', 'min_score' => 0, 'max_score' => 5, 'order' => 7],
        ];

        foreach ($pembimbing as $item) {
            EvaluationComponent::updateOrCreate(
                ['role' => 'pembimbing', 'name' => $item['name']],
                $item + ['role' => 'pembimbing']
            );
        }

        foreach ($penguji as $item) {
            EvaluationComponent::updateOrCreate(
                ['role' => 'penguji', 'name' => $item['name']],
                $item + ['role' => 'penguji']
            );
        }
    }
}