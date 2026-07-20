<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarEvaluation extends Model
{
    use HasFactory;

    protected $table = 'seminar_evaluations';

    protected $fillable = [
        'skripsi_id',
        'lecturer_id',
        'evaluator_role',
        'scores',
        'total_score',
        'bobot',
        'nilai_akhir',
        'notes',
        'evaluation_date',
    ];

    protected $casts = [
        'scores' => 'array',
        'total_score' => 'decimal:2',
        'bobot' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
        'evaluation_date' => 'date',
    ];

    /**
     * Komponen penilaian untuk dosen PEMBIMBING (8 item, total maksimal 100).
     * Beda dari penguji: ada tambahan item "pembimbingan" (checklist berkas),
     * sehingga bobot Keterkaitan & Pemahaman Metode lebih kecil dari penguji.
     */
    public const PEMBIMBING_COMPONENTS = [
        'pembimbingan' => ['label' => 'Pembimbingan (Checklist Berkas)', 'max' => 10],
        'abstrak' => ['label' => 'Abstrak Proposal', 'max' => 5],
        'keterkaitan' => ['label' => 'Keterkaitan: Latar Belakang, Batasan, Rumusan, Tujuan, Manfaat Penelitian', 'max' => 20],
        'pemahaman_metode' => ['label' => 'Pemahaman Terhadap Metode/Algoritma yang Digunakan', 'max' => 20],
        'landasan_teori' => ['label' => 'Kelengkapan dan Pemahaman Landasan Teori', 'max' => 20],
        'metodologi' => ['label' => 'Kejelasan Metodologi Penelitian', 'max' => 10],
        'pustaka' => ['label' => 'Kebaruan Pustaka/Referensi', 'max' => 10],
        'arsitektur' => ['label' => 'Rancangan Arsitektur Sistem/Struktur Menu/Antarmuka/Prototype', 'max' => 5],
    ];

    /**
     * Komponen penilaian untuk dosen PENGUJI (7 item, total maksimal 100).
     * Tidak ada item pembimbingan karena itu bukan tugas penguji.
     */
    public const PENGUJI_COMPONENTS = [
        'abstrak' => ['label' => 'Abstrak Proposal', 'max' => 5],
        'keterkaitan' => ['label' => 'Keterkaitan: Latar Belakang, Batasan, Rumusan, Tujuan, Manfaat Penelitian', 'max' => 25],
        'pemahaman_metode' => ['label' => 'Pemahaman Terhadap Metode/Algoritma yang Digunakan', 'max' => 25],
        'landasan_teori' => ['label' => 'Kelengkapan dan Pemahaman Landasan Teori', 'max' => 20],
        'metodologi' => ['label' => 'Kejelasan Metodologi Penelitian', 'max' => 10],
        'pustaka' => ['label' => 'Kebaruan Pustaka/Referensi', 'max' => 10],
        'arsitektur' => ['label' => 'Rancangan Arsitektur Sistem/Struktur Menu/Antarmuka/Prototype', 'max' => 5],
    ];

    /**
     * Ambil daftar komponen penilaian sesuai peran penilai.
     */
    public static function components(string $role): array
    {
        return $role === 'pembimbing' ? self::PEMBIMBING_COMPONENTS : self::PENGUJI_COMPONENTS;
    }

    /**
     * Otomatis hitung total_score (jumlah semua komponen) dan nilai_akhir
     * (total_score * bobot / 100) setiap kali data disimpan, supaya
     * controller tidak perlu menghitung manual dan tidak ada data yang
     * tidak sinkron antara scores, total_score, dan nilai_akhir.
     */
    protected static function booted(): void
    {
        static::saving(function (SeminarEvaluation $evaluation) {
            $scores = $evaluation->scores ?? [];
            $total = array_sum(array_map('floatval', $scores));

            $evaluation->total_score = $total;
            $evaluation->nilai_akhir = round($total * ((float) $evaluation->bobot) / 100, 2);
        });
    }

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}