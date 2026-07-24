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
        'user_id',
        'student_id',
        'name',
        'email',
        'year_entrance',
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

    /**
     * Relasi asli ke akun User (login) lewat kolom user_id.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ambil akun User (login) milik mahasiswa ini.
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