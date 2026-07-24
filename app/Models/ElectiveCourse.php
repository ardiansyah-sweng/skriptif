<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectiveCourse extends Model
{
    /**
     * Nama tabel.
     */
    protected $table = 'elective_courses';

    protected $primaryKey = 'id';

    /**
     * Tipe data primary key.
     */
    protected $keyType = 'int';

    /**
     * Nonaktifkan timestamps otomatis (created_at & updated_at).
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'courses',
        'timestamp',
    ];

    public function skripsis()
    {
        return $this->belongsToMany(
            Skripsi::class,
            'elective_course_skripsi',
            'elective_course_id',
            'skripsi_id'
        );
    }

}
