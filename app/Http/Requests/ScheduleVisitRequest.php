<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'visit_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom message validation.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Sales pelaksana wajib dipilih.',
            'user_id.exists' => 'Sales yang dipilih tidak ditemukan dalam sistem.',
            'store_id.required' => 'Toko tujuan wajib dipilih.',
            'store_id.exists' => 'Toko yang dipilih tidak ditemukan dalam sistem.',
            'visit_date.required' => 'Tanggal rencana kunjungan wajib diisi.',
            'visit_date.date' => 'Format tanggal kunjungan tidak valid.',
        ];
    }
}
