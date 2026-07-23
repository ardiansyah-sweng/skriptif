<?php

namespace App\Http\Requests;

use App\Models\EvaluationComponent;
use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'skripsi_id' => 'required|exists:skripsi,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'role' => 'required|in:pembimbing,penguji',
            'weight' => 'required|numeric|min:0|max:100',
            'evaluation_date' => 'required|date',
            'notes' => 'nullable|string',
            'components' => 'required|array',
        ];

        // Rentang nilai tiap unsur beda-beda tergantung peran,
        // jadi divalidasi dinamis per unsur sesuai role yang dipilih.
        $role = $this->input('role');

        if (in_array($role, ['pembimbing', 'penguji'], true)) {
            foreach (EvaluationComponent::forRole($role)->get() as $component) {
                $rules["components.{$component->id}"] = sprintf(
                    'required|numeric|min:%s|max:%s',
                    $component->min_score,
                    $component->max_score
                );
            }
        } else {
            $rules['components.*'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'skripsi_id.required' => 'Skripsi wajib dipilih.',
            'skripsi_id.exists' => 'Skripsi yang dipilih tidak ditemukan.',
            'lecturer_id.required' => 'Dosen wajib dipilih.',
            'lecturer_id.exists' => 'Dosen yang dipilih tidak ditemukan.',
            'role.required' => 'Peran penilai (Pembimbing/Penguji) wajib dipilih.',
            'role.in' => 'Peran penilai tidak valid.',
            'weight.numeric' => 'Bobot harus berupa angka.',
            'weight.max' => 'Bobot maksimal 100.',
            'evaluation_date.required' => 'Tanggal evaluasi wajib diisi.',
            'components.required' => 'Komponen penilaian wajib diisi.',
            'components.*.required' => 'Nilai unsur ini wajib diisi.',
            'components.*.numeric' => 'Nilai unsur harus berupa angka.',
            'components.*.min' => 'Nilai unsur tidak boleh kurang dari rentang minimal.',
            'components.*.max' => 'Nilai unsur tidak boleh melebihi rentang maksimal.',
        ];
    }
}