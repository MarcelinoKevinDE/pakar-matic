<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiagnosaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    return [
        'nama_user' => ['nullable', 'string', 'max:100'],
        'gejala'    => ['required', 'array', 'min:1'],
        'gejala.*'  => ['required', 'integer', 'exists:gejalas,id'],
    ];
}

    public function attributes(): array
    {
        return [
            'gejala'   => 'pilihan gejala',
            'gejala.*' => 'gejala',
        ];
    }

    public function messages(): array
    {
        return [
            'gejala.required' => 'Pilih minimal satu gejala sebelum menjalankan diagnosis.',
            'gejala.min'      => 'Pilih minimal :min gejala untuk melanjutkan.',
            'gejala.array'    => 'Format gejala tidak valid. Silakan muat ulang halaman.',
            'gejala.*.exists' => 'Salah satu gejala yang dipilih tidak valid.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors'  => $validator->errors(),
                ], 422)
            );
        }

        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}