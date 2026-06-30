<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    /**
     * Table name
     */
    protected $table = 'exam_schedules';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'skripsi_id',
        'jenis_sidang',
        'tanggal_sidang',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'status',
        'catatan',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'terjadwal',
    ];

    /**
     * Attribute casts
     */
    protected $casts = [
        'tanggal_sidang' => 'date',
    ];

    /**
     * Relasi ke Skripsi
     */
    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }
}
