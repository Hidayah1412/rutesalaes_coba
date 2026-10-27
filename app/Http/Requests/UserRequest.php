<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('sale') ?? $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => $this->isMethod('post')
                ? ['required', 'string', 'min:6']
                : ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,sales'],
            'phone' => ['nullable', 'string', 'max:30'],
            'employee_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('users', 'employee_code')->ignore($userId),
            ],
            'is_active' => ['nullable'],
        ];
    }

    /**
     * Custom message validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.required' => 'Peran (Role) wajib dipilih.',
            'role.in' => 'Peran harus berupa admin atau sales.',
            'employee_code.unique' => 'Kode pegawai sudah terdaftar.',
        ];
    }
}
