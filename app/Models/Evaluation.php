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
     * Setiap kali skor disimpan, grade huruf ikut otomatis dihitung ulang
     * supaya controller tidak perlu mikirin konversi manual tiap saat.
     */
    protected static function booted(): void
    {
        static::saving(function (Evaluation $evaluation) {
            $evaluation->grade = self::convertScoreToGrade($evaluation->score);
        });
    }

    /**
     * Konversi nilai 0-100 ke huruf.
     * Batas nilai bisa disesuaikan kalau standar kampus beda.
     */
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