<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['required', 'string'],
            'area' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom message validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama toko/warung wajib diisi.',
            'name.max' => 'Nama toko maksimal 255 karakter.',
            'owner_name.required' => 'Nama pemilik toko wajib diisi.',
            'address.required' => 'Alamat lengkap toko wajib diisi.',
            'status.required' => 'Status toko wajib dipilih.',
            'status.in' => 'Status toko harus berupa active atau inactive.',
            'latitude.numeric' => 'Latitude harus berupa angka koordinat yang valid.',
            'longitude.numeric' => 'Longitude harus berupa angka koordinat yang valid.',
        ];
    }
}
