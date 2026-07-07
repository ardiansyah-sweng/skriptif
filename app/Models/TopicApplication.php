<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicApplication extends Model
{
    protected $table = 'topic_applications';

    protected $fillable = [
        'student_id',
        'lecturer_topic_id',
        'applicant_name',
        'applicant_nim',
        'document_path',
        'requirements_note',
        'status',
        'message',
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function lecturerTopic()
    {
        return $this->belongsTo(LecturerTopic::class, 'lecturer_topic_id');
    }
}
