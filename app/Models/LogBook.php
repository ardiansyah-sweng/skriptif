<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LogBook extends Model
{
    use HasFactory;
    protected $table = 'log_books';
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'date',
        'activity',
        'feedback',
        'status',
    ];
    protected $casts = [
        'date' => 'date',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
