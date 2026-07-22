<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarProposalDocument extends Model
{
    protected $table = 'seminar_proposal_documents';

    protected $fillable = [
        'skripsi_id',
        'bukti_turnitin',
        'bukti_literasi',
        'bukti_transkrip',
        'bukti_toefl',
    ];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }
}
