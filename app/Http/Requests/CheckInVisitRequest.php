<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInVisitRequest extends FormRequest
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
            'result_status' => ['required', 'in:Berhasil,Tutup,Ditolak'],
            'check_in_time' => ['required'],
            'order_value' => [
                'required_if:result_status,Berhasil',
                'nullable',
                'numeric',
                'min:0',
            ],
            'fail_reason' => [
                'required_if:result_status,Tutup,Ditolak',
                'nullable',
                'string',
                'min:3',
                'max:1000',
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
            'simulated_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'simulated_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * Custom message validation.
     */
    public function messages(): array
    {
        return [
            'result_status.required' => 'Hasil status kunjungan wajib dipilih (Berhasil, Tutup, atau Ditolak).',
            'result_status.in' => 'Status hasil harus berupa Berhasil, Tutup, atau Ditolak.',
            'check_in_time.required' => 'Waktu check-in kunjungan wajib diisi.',
            'order_value.required_if' => 'Nilai nominal pesanan wajib diisi jika kunjungan Berhasil.',
            'order_value.numeric' => 'Nilai pesanan harus berupa nominal angka yang valid.',
            'order_value.min' => 'Nilai pesanan tidak boleh bernilai negatif.',
            'fail_reason.required_if' => 'Alasan wajib diisi jika toko Tutup atau Ditolak.',
            'fail_reason.min' => 'Alasan kunjungan minimal 3 karakter.',
            'simulated_latitude.numeric' => 'Koordinat latitude simulasi harus berupa angka.',
            'simulated_longitude.numeric' => 'Koordinat longitude simulasi harus berupa angka.',
        ];
    }
}
