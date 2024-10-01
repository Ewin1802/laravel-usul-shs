<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required|max:100|min:3',
    //         'email' => 'required|email|unique:users,email',
    //         'phone' => 'required',
    //         'skpd' => 'required|exists:skpds,nama_skpd',
    //         'roles' => 'required|in:ADMIN,SKPD,USER',
    //     ];
    // }
    public function rules(): array
    {
        return [
            'name' => 'required|max:100|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user->id,  // Mengabaikan email unik untuk user yang sedang diedit
            'phone' => 'required',
            'skpd' => 'required|exists:skpds,nama_skpd',  // Validasi bahwa SKPD harus ada di tabel `skpds`
            'roles' => 'required|in:ADMIN,SKPD,USER',
            'password' => 'nullable|min:8',  // Password tidak wajib, hanya divalidasi jika diisi
        ];
    }

}
