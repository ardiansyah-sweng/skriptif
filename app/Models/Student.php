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
        'status',
    ];
    /**
     * Attribute casting
     */
    protected $casts = [
        'year_entrance' => 'integer',
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