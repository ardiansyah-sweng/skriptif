<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportElectiveCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }
}