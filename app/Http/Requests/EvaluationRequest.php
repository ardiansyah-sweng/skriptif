<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sementara true karena belum ada login. Nanti kalau login dosen sudah
        // jalan, ganti jadi cek role dosen penguji, contoh:
        // return auth()->check() && auth()->user()->role === 'dosen';
        return true;
    }

    public function rules(): array
    {
        return [
            'skripsi_id' => 'required|exists:skripsi,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'evaluation_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'skripsi_id.required' => 'Skripsi wajib dipilih.',
            'skripsi_id.exists' => 'Skripsi yang dipilih tidak ditemukan.',
            'lecturer_id.required' => 'Dosen penguji wajib dipilih.',
            'lecturer_id.exists' => 'Dosen yang dipilih tidak ditemukan.',
            'score.required' => 'Nilai wajib diisi.',
            'score.numeric' => 'Nilai harus berupa angka.',
            'score.min' => 'Nilai minimal 0.',
            'score.max' => 'Nilai maksimal 100.',
            'evaluation_date.required' => 'Tanggal evaluasi wajib diisi.',
        ];
    }
}