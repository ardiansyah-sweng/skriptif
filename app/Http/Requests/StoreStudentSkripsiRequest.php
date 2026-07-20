<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentSkripsiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'supervisor_id' => 'required|exists:lecturers,id',
            'elective_courses' => 'required|array|min:1',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'supervisor_id.required' => 'Pilih dosen pembimbing.',
            'elective_courses.required' => 'Minimal satu mata kuliah.',
            'document.required' => 'Dokumen proposal wajib diunggah.',
            'document.file' => 'Dokumen harus berupa berkas yang valid.',
            'document.mimes' => 'Format dokumen harus PDF, DOC, atau DOCX.',
            'document.max' => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}