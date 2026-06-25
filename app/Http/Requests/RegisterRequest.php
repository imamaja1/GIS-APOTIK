<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_user' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:100', 'unique:tb_user,email'],
            'password'  => ['required', 'confirmed', Password::min(6)],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_user.required' => 'Username wajib diisi.',
            'nama_user.max'      => 'Username maksimal 100 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
        ];
    }
}
