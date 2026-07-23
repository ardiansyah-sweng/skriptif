<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'skripsi_id',
        'lecturer_id',
        'role',          // Pastikan ini ditambahkan agar bisa di-insert via controller
        'weight',        // Pastikan ini ditambahkan agar bisa di-insert via controller
        'score',
        'grade',
        'notes',
        'evaluation_date',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'evaluation_date' => 'date',
    ];

    /**
     * Relasi ke detail nilai komponen evaluasi (EvaluationComponentScore)
     */
    public function componentScores()
    {
        return $this->hasMany(EvaluationComponentScore::class, 'evaluation_id');
    }

    /**
     * Sinkronisasi nilai komponen dan hitung total score otomatis.
     */
    public function syncComponentScores(array $scoresInput): void
    {
        $totalScore = 0;

        foreach ($scoresInput as $componentId => $scoreValue) {
            $scoreValue = (float) $scoreValue;
            $totalScore += $scoreValue;

            $this->componentScores()->updateOrCreate(
                ['evaluation_component_id' => $componentId],
                ['score' => $scoreValue]
            );
        }

        // Simpan total skor akhir, otomatis memicu boot saving untuk mengubah ke grade huruf
        $this->update(['score' => $totalScore]);
    }

    /**
     * FIX: Nilai Akhir = Nilai (score) x Bobot (weight) / 100.
     * Sebelumnya $evaluation->final_score selalu null karena tidak pernah
     * didefinisikan sebagai kolom maupun accessor, sehingga di semua
     * view (index, show) dan rekap di controller selalu tampil 0.0.
     * Dihitung otomatis lewat accessor, tidak perlu kolom tambahan di DB,
     * supaya selalu sinkron kalau score atau weight berubah.
     */
    public function getFinalScoreAttribute(): float
    {
        return round(((float) $this->score) * ((float) $this->weight) / 100, 2);
    }

    /**
     * Otomatis hitung grade huruf setiap kali skor disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (Evaluation $evaluation) {
            $evaluation->grade = self::convertScoreToGrade($evaluation->score);
        });
    }

    public static function convertScoreToGrade(float|string $score): string
    {
        $score = (float) $score;

        return match (true) {
            $score >= 85 => 'A',
            $score >= 70 => 'B',
            $score >= 55 => 'C',
            $score >= 40 => 'D',
            default => 'E',
        };
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