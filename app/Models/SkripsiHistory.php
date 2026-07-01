<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkripsiHistory extends Model
{
    use HasFactory;

    protected $table = 'skripsi_histories';

    protected $fillable = [
        'skripsi_id',
        'status',
        'handler_id',
        'note',
    ];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }
}
