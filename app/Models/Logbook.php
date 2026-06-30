<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbooks';

    protected $fillable = [
        'skripsi_id',
        'evaluator_id',
        'logbook_type',
        'overall_score',
        'grade_letter',
        'revision_notes',
        'status',
        'logbook_date',
    ];

    protected $casts = [
        'logbook_date' => 'date',
    ];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(Lecturer::class, 'evaluator_id');
    }
}