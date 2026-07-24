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
        'user_id',
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

    /**
     * Relasi asli ke akun User (login) lewat kolom user_id.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ambil akun User (login) milik dosen ini.
     * Kalau user_id masih kosong (data lama sebelum relasi ini dibuat),
     * coba cari lewat email dan tautkan otomatis biar berikutnya tidak perlu dicari lagi.
     */
    public function account()
    {
        if ($this->user_id) {
            return $this->user;
        }

        $matchedUser = User::where('email', $this->email)->first();

        if ($matchedUser) {
            $this->update(['user_id' => $matchedUser->id]);
        }

        return $matchedUser;
    }
}