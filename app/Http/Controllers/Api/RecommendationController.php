<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;

class RecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $judul = strtolower($request->query('title', ''));

        // Skrip hanya berjalan jika input judul minimal 15 karakter
        if (strlen($judul) < 15) {
            return response()->json([]);
        }

        // Daftar eliminasi kata (stopwords) Bahasa Indonesia yang tidak membawa makna esensial topik
        $stopwords = ['analisis', 'perancangan', 'sistem', 'berbasis', 'menggunakan', 'pada', 'aplikasi', 'implementasi', 'studi', 'kasus', 'dan', 'di', 'dengan', 'secara', 'metode', 'tugas', 'akhir'];

        // Tokenisasi dokumen judul
        $cleanTitle = preg_replace('/[^\w\s]/', '', $judul);
        $judulWords = explode(' ', $cleanTitle);
        $filteredWords = array_diff($judulWords, $stopwords);

        // Ambil data dosen dengan teknik Eager Loading Aggregates untuk menghitung status skripsi 'approved'
        $lecturers = Lecturer::withCount(['skripsi as total_bimbingan_aktif' => function ($query) {
            $query->where('status', 'approved');
        }])->get();

        $recommendations = $lecturers->map(function ($lecturer) use ($filteredWords) {
            if (empty($lecturer->expertise)) {
                return [
                    'id' => $lecturer->id,
                    'name' => $lecturer->name,
                    'expertise' => '-',
                    'sisa_kuota' => $lecturer->max_supervisors - $lecturer->total_bimbingan_aktif,
                    'score' => 0
                ];
            }

            // Normalisasi tag keahlian dosen menjadi array komponen kata
            $expertiseWords = array_map('trim', explode(',', strtolower($lecturer->expertise)));

            // Hitung frekuensi irisan kata kunci antara judul dan keahlian dosen
            $score = 0;
            foreach ($filteredWords as $word) {
                if (empty($word)) continue;
                foreach ($expertiseWords as $expertise) {
                    if (str_contains($expertise, $word) || str_contains($word, $expertise)) {
                        $score++;
                    }
                }
            }

            $sisaKuota = $lecturer->max_supervisors - $lecturer->total_bimbingan_aktif;

            return [
                'id' => $lecturer->id,
                'name' => $lecturer->name,
                'expertise' => $lecturer->expertise,
                'sisa_kuota' => $sisaKuota,
                'score' => $score
            ];
        })
        ->filter(function ($item) {
            // Hanya lolos penyaringan jika ada kecocokan istilah DAN kuota pembimbing masih tersedia
            return $item['score'] > 0 && $item['sisa_kuota'] > 0;
        })
        ->sortByDesc('score') // Tempatkan skor kecocokan tertinggi di baris teratas
        ->values()
        ->take(3); // Batasi keluaran objek JSON hanya 3 rekomendasi utama

        return response()->json($recommendations);
    }
}
