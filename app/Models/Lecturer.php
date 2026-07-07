<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'status'
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'active',
    ];
    public function skripsis()
    {
        // Relasi ke tabel skripsi menggunakan foreign key 'supervisor_id'
        return $this->hasMany(Skripsi::class, 'supervisor_id');
    }
    

    /**
     * Timestamps
     */
    public $timestamps = true;
}