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
        'evaluator_id',
        'evaluation_type',
        'overall_score',
        'grade_letter',
        'revision_notes',
        'status',
        'evaluation_date',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
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