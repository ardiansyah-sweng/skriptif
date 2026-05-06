<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'year_entrance',
        'status',
    ];

    public $timestamps = true;
}