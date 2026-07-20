<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skripsi;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\LogBook;
use Carbon\Carbon;

class UtilityController extends Controller
{
    // 1. Deteksi Duplikasi Judul
    public function similarityCheck(Request $request)
    {
        $inputTitle = $request->input('title');
        $results = [];

        if ($inputTitle) {
            $cleanInput = strtolower(preg_replace('/[^\w\s]/', '', $inputTitle));
            $approvedSkripsi = Skripsi::with('student', 'supervisor')
                ->where('status', 'approved')
                ->get();

            foreach ($approvedSkripsi as $skripsi) {
                $cleanTitle = strtolower(preg_replace('/[^\w\s]/', '', $skripsi->title));
                
                // Hitung persentase kemiripan
                similar_text($cleanInput, $cleanTitle, $percent);

                // Cari kata yang sama (overlap)
                $inputWords = array_unique(explode(' ', $cleanInput));
                $titleWords = array_unique(explode(' ', $cleanTitle));
                $matchingWords = array_intersect($inputWords, $titleWords);
                
                // Abaikan kata hubung/stop words pendek dalam visualisasi overlap
                $stopWords = ['dan', 'di', 'ke', 'yang', 'dengan', 'tentang', 'pada', 'untuk', 'dari', 'dalam', 'sistem', 'aplikasi', 'web', 'berbasis', 'menggunakan'];
                $matchingWordsCleaned = array_diff($matchingWords, $stopWords);

                if ($percent >= 25 || count($matchingWordsCleaned) > 0) {
                    $results[] = [
                        'skripsi' => $skripsi,
                        'percent' => round($percent, 2),
                        'matched_words' => array_values($matchingWordsCleaned)
                    ];
                }
            }

            // Urutkan berdasarkan persentase tertinggi
            usort($results, function ($a, $b) {
                return $b['percent'] <=> $a['percent'];
            });
        }

        return view('utilities.similarity', compact('inputTitle', 'results'));
    }

    // 2. Rekomendasi Dosen Pembimbing
    public function supervisorRecommendation(Request $request)
    {
        $title = $request->input('title');
        $results = [];

        if ($title) {
            $cleanTitle = strtolower(preg_replace('/[^\w\s]/', '', $title));
            $titleWords = array_unique(explode(' ', $cleanTitle));
            
            // Bersihkan stop words
            $stopWords = ['dan', 'di', 'ke', 'yang', 'dengan', 'tentang', 'pada', 'untuk', 'dari', 'dalam', 'sistem', 'aplikasi', 'web', 'berbasis', 'menggunakan', 'rancangan', 'pembuatan', 'analisis'];
            $keywords = array_diff($titleWords, $stopWords);

            $lecturers = Lecturer::all();

            foreach ($lecturers as $lecturer) {
                $score = 0;
                $matchedKeywords = [];
                
                // Cek keahlian dosen
                if ($lecturer->expertise) {
                    $cleanExpertise = strtolower(preg_replace('/[^\w\s]/', '', $lecturer->expertise));
                    foreach ($keywords as $word) {
                        if (strlen($word) > 2 && str_contains($cleanExpertise, $word)) {
                            $score += 15;
                            $matchedKeywords[] = $word;
                        }
                    }
                }

                // Hitung kapasitas bimbingan aktif saat ini
                $activeCount = Skripsi::where('supervisor_id', $lecturer->id)
                    ->where('status', 'approved')
                    ->count();

                $capacity = (int) ($lecturer->max_supervisors ?? 12) - $activeCount;

                // Modifikasi score berdasarkan sisa kuota bimbingan
                if ($capacity <= 0) {
                    // Pinalti jika kuota sudah penuh
                    $score -= 50;
                } else {
                    // Tambahan skor kecil untuk dosen yang kuotanya masih sangat longgar
                    $score += $capacity * 2;
                }

                $results[] = [
                    'lecturer' => $lecturer,
                    'active_count' => $activeCount,
                    'capacity' => $capacity,
                    'score' => $score,
                    'matched_keywords' => $matchedKeywords
                ];
            }

            // Urutkan berdasarkan score tertinggi
            usort($results, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });
        }

        return view('utilities.supervisor', compact('title', 'results'));
    }

    // 3. Pelacak Masa Studi & Kritis
    public function progressTracker()
    {
        $students = Student::where('status', 'active')->get();
        $criticalStudents = [];

        foreach ($students as $student) {
            // Hanya deteksi mahasiswa yang memiliki skripsi disetujui (artinya sedang aktif skripsi)
            $hasApprovedSkripsi = Skripsi::where('student_id', $student->id)
                ->where('status', 'approved')
                ->first();

            if ($hasApprovedSkripsi) {
                // Ambil logbook bimbingan terbaru
                $latestLog = LogBook::where('student_id', $student->id)
                    ->orderBy('date', 'desc')
                    ->first();

                if (!$latestLog) {
                    $criticalStudents[] = [
                        'student' => $student,
                        'skripsi' => $hasApprovedSkripsi,
                        'latest_date' => null,
                        'days_inactive' => 999, // Sangat lama/belum pernah
                        'status_text' => 'Belum pernah melakukan bimbingan'
                    ];
                } else {
                    $lastDate = Carbon::parse($latestLog->date);
                    $days = $lastDate->diffInDays(Carbon::now());
                    
                    if ($days >= 30) {
                        $criticalStudents[] = [
                            'student' => $student,
                            'skripsi' => $hasApprovedSkripsi,
                            'latest_date' => $lastDate->format('d M Y'),
                            'days_inactive' => $days,
                            'status_text' => "Tidak aktif bimbingan selama {$days} hari"
                        ];
                    }
                }
            }
        }

        // Urutkan berdasarkan keaktifan paling kritis (hari tidak aktif terbanyak)
        usort($criticalStudents, function ($a, $b) {
            return $b['days_inactive'] <=> $a['days_inactive'];
        });

        return view('utilities.progress', compact('criticalStudents'));
    }

    // 4. Unduh Panduan & Repositori
    public function documentRepository()
    {
        $templates = [
            [
                'id' => 'panduan_skripsi',
                'title' => 'Buku Panduan Penulisan Skripsi',
                'description' => 'Pedoman resmi tata cara penulisan proposal, bab pembahasan, hingga format penulisan daftar pustaka.',
                'file_name' => 'Buku_Panduan_Skripsi.pdf',
                'type' => 'PDF',
                'icon' => 'fa-file-pdf text-danger'
            ],
            [
                'id' => 'template_proposal',
                'title' => 'Template Proposal Skripsi (DOCX)',
                'description' => 'Format Microsoft Word resmi untuk penyusunan Bab 1, Bab 2, dan Bab 3 proposal skripsi.',
                'file_name' => 'Template_Proposal_Skripsi.docx',
                'type' => 'DOCX',
                'icon' => 'fa-file-word text-primary'
            ],
            [
                'id' => 'form_sidang',
                'title' => 'Formulir Pendaftaran Sidang Skripsi',
                'description' => 'Lembar isian kelayakan dan persetujuan dosen pembimbing untuk pendaftaran ujian skripsi.',
                'file_name' => 'Form_Pendaftaran_Sidang.pdf',
                'type' => 'PDF',
                'icon' => 'fa-file-pdf text-danger'
            ],
            [
                'id' => 'form_bimbingan',
                'title' => 'Lembar Kartu Konsultasi Bimbingan',
                'description' => 'Formulir fisik/cetak rekap bimbingan jika diperlukan lampiran tanda tangan basah dosen.',
                'file_name' => 'Kartu_Konsultasi_Bimbingan.docx',
                'type' => 'DOCX',
                'icon' => 'fa-file-word text-primary'
            ]
        ];

        return view('utilities.repository', compact('templates'));
    }

    // Aksi untuk mengunduh template secara dinamis tanpa butuh file asli di storage
    public function downloadTemplate($file)
    {
        $content = "";
        $filename = "Dokumen_Template.txt";

        if ($file === 'panduan_skripsi') {
            $filename = 'Buku_Panduan_Skripsi.pdf';
            $content = "%PDF-1.4 ... [Dokumen Mock: Buku Panduan Penulisan Skripsi Mahasiswa]";
        } elseif ($file === 'template_proposal') {
            $filename = 'Template_Proposal_Skripsi.docx';
            $content = "[Dokumen Mock: Template Struktur Proposal Skripsi DOCX]";
        } elseif ($file === 'form_sidang') {
            $filename = 'Form_Pendaftaran_Sidang.pdf';
            $content = "%PDF-1.4 ... [Dokumen Mock: Formulir Pendaftaran Ujian/Sidang Skripsi]";
        } elseif ($file === 'form_bimbingan') {
            $filename = 'Kartu_Konsultasi_Bimbingan.docx';
            $content = "[Dokumen Mock: Kartu Rekap Bimbingan Konsultasi]";
        }

        return response($content)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
