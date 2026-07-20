<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationComponentScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'evaluation_component_id',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function component()
    {
        return $this->belongsTo(EvaluationComponent::class, 'evaluation_component_id');
    }
}