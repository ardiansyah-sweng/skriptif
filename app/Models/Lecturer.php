<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Skripsi; 

class Lecturer extends Model
{
    /**
     * Table name
     */
    protected $table = 'lecturers';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'lecturer_id',
        'name',
        'email',
        'expertise',
        'max_supervisors',
        'status'
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'active',
    ];

    // Relasi ke tabel Skripsi (Satu dosen bisa membimbing banyak skripsi)
    public function skripsis()
    {
        return $this->hasMany(Skripsi::class, 'supervisor_id');
    }

    // Accessor untuk menghitung jumlah mahasiswa bimbingan yang AKTIF (di-ACC)
    public function getActiveBimbinganCountAttribute()
    {
        return $this->skripsis()->where('status', 'approved')->count();
    }

    /**
     * Timestamps
     */
    public $timestamps = true;
}