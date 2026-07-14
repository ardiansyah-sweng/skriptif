<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    /**
     * Table name
     */
    protected $table = 'lecturers';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'lecturer_id',
        'name',
        'email',
        'expertise',
        'max_supervisors',
        'status'
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'active',
    ];
    

    /**
     * Timestamps
     */
    public $timestamps = true;
}