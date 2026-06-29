<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingans';

    protected $fillable = [
        'skripsi_id',
        'lecturer_id',
        'tanggal_bimbingan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bimbingan' => 'date',
    ];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
