<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectiveCourse extends Model
{
    /**
     * Table name
     */
    protected $table = 'elective_courses';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**

     * Isi setelah migration tabel `elective_courses` selesai.
     * Contoh kolom yang mungkin: 'course_code', 'name', 'credits', 'semester', 'quota', 'status'
     */
    protected $fillable = [
        // Tunggu migration selesai, lalu tambahkan kolom di sini.
    ];

    /**
     * Attribute casting
     *
     * Sesuaikan tipe cast setelah migration selesai.
     * Contoh:
     *   'credits'  => 'integer',
     *   'quota'    => 'integer',
     *   'is_active' => 'boolean',
     */
    protected function casts(): array
    {
        return [
            // Tunggu migration selesai.
        ];
    }

   
    public $timestamps = true;

    // =========================================================================
    // RELASI — Tambahkan setelah migration & model terkait tersedia
    // =========================================================================

    /**
     * Contoh relasi yang mungkin dibutuhkan:
     *
     * // Dosen pengampu
     * public function lecturer(): BelongsTo
     * {
     *     return $this->belongsTo(Lecturer::class);
     * }
     *
     * // Mahasiswa yang mengambil MK pilihan ini
     * public function students(): BelongsToMany
     * {
     *     return $this->belongsToMany(Student::class, 'elective_course_student');
     * }
     */
}
