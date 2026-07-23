<?php

namespace App\Http\Requests;

use App\Models\SeminarEvaluation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SeminarEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sementara true karena belum ada login. Nanti kalau login dosen
        // sudah jalan, sesuaikan pengecekan role (pembimbing/penguji).
        return true;
    }

    public function rules(): array
    {
        return [
            'skripsi_id' => 'required|exists:skripsi,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'evaluator_role' => 'required|in:pembimbing,penguji',
            'scores' => 'required|array',
            'evaluation_date' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Validasi tambahan: setiap komponen skor wajib diisi dan tidak boleh
     * melebihi nilai maksimal komponen tersebut (beda-beda tergantung role).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $role = $this->input('evaluator_role');

            if (!in_array($role, ['pembimbing', 'penguji'], true)) {
                return;
            }

            $components = SeminarEvaluation::components($role);
            $scores = $this->input('scores', []);

            foreach ($components as $code => $component) {
                if (!isset($scores[$code]) || $scores[$code] === '') {
                    $validator->errors()->add("scores.$code", "{$component['label']} wajib diisi.");
                    continue;
                }

                if (!is_numeric($scores[$code])) {
                    $validator->errors()->add("scores.$code", "{$component['label']} harus berupa angka.");
                    continue;
                }

                if ($scores[$code] < 0 || $scores[$code] > $component['max']) {
                    $validator->errors()->add(
                        "scores.$code",
                        "{$component['label']} harus di antara 0 - {$component['max']}."
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'skripsi_id.required' => 'Skripsi wajib dipilih.',
            'lecturer_id.required' => 'Dosen wajib dipilih.',
            'evaluator_role.required' => 'Peran penilai wajib dipilih.',
            'evaluation_date.required' => 'Tanggal evaluasi wajib diisi.',
        ];
    }
}