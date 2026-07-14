<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Table name
     */
    protected $table = 'students';
    /**
     * Primary key
     */
    protected $primaryKey = 'id';
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'year_entrance',
        'study_program',
        'status',
        'is_lulus',
    ];
    /**
     * Attribute casting
     */
    protected $casts = [
        'year_entrance' => 'integer',
        'is_lulus'      => 'boolean',
    ];
    public $timestamps = true;
    /**
     * Optional: default values
     */
    protected $attributes = [
        'status' => 'active',
    ];

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'student_id');
    }
}