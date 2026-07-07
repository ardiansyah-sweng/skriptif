<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerTopic extends Model
{
    protected $table = 'lecturer_topics';

    protected $fillable = [
        'lecturer_id',
        'title',
        'description',
        'requirements',
        'status',
        'capacity',
        'applied_count',
        'deadline',
        'attachment',
    ];

    public $timestamps = true;

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function applications()
    {
        return $this->hasMany(TopicApplication::class, 'lecturer_topic_id');
    }
}
