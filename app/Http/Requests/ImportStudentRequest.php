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
    // trigger commit
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls|max:2048', 
        ];
    }
}