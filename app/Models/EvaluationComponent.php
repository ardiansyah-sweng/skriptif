<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'name',
        'min_score',
        'max_score',
        'order',
    ];

    protected $casts = [
        'min_score' => 'decimal:2',
        'max_score' => 'decimal:2',
    ];

    public function componentScores()
    {
        return $this->hasMany(EvaluationComponentScore::class);
    }

    /**
     * Ambil unsur penilaian untuk satu rubrik saja, terurut sesuai tampilan.
     */
    public function scopeForRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role)->orderBy('order');
    }
}