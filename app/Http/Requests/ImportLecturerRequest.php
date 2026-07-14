<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportLecturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File import dosen wajib dipilih.',
            'file.file'     => 'File import harus berupa berkas yang valid.',
            'file.mimes'    => 'Format file harus CSV atau TXT.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ];
    }
}