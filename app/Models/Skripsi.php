<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skripsi extends Model
{
    protected $table = 'skripsi';

    protected $fillable = [
        'student_id',
        'supervisor_id',
        'title',
        'description',
        'suggestion_supervisor',
        'status',
        'rejection_note',
        'submission_date',
        'approval_date',
        'elective_courses',
    ];

    protected $casts = [
        'elective_courses'  => 'array',
        'submission_date'   => 'datetime',
        'approval_date'     => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }

    public function suggestionSupervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'suggestion_supervisor');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}