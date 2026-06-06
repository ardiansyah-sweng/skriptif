<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectiveCourse extends Model
{
    /**
     * Nama tabel.
     */
    protected $table = 'elective_courses';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id';

    /**
     * Tipe data primary key.
     */
    protected $keyType = 'int';

    /**
     * Apakah primary key auto-increment.
     */
    public $incrementing = true;

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

    /**
     * Casting atribut ke tipe native PHP.
     *
     * - 'timestamp' di-cast ke 'datetime' agar Eloquent mengembalikan
     *   instance Carbon, sehingga bisa diformat, dibandingkan, dan
     *   dimanipulasi dengan mudah (misal: $model->timestamp->format('d-m-Y')).
     */
    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }
}
