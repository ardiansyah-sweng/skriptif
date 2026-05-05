<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sama)
    protected $table = 'lecturers';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'lecturer_id',
        'name',
        'email',
        'expertise'
    ];

    // Kalau pakai created_at & updated_at
    public $timestamps = true;
}