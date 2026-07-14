<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportStudentRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Aturan validasi
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:2048', 
        ];
    }
}