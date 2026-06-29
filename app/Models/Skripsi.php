<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'skripsi';

    protected $fillable = [
        'student_id',
        'supervisor_id',
        'title',
        'description',
        'status',
        'rejection_note',
        'submission_date',
        'approval_date',
        'elective_courses',
    ];

    protected $casts = [
        'elective_courses' => 'array',
        'submission_date'  => 'date',
        'approval_date'    => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Lecturer::class, 'supervisor_id');
    }

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class)->latest('tanggal_sidang');
    }
}