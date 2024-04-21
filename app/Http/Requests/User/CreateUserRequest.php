<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'      => 'required',
            'username'  => 'required|unique:users,username',
            'password'  => 'required|confirmed',
            'user_level'=> 'required',
            'user_foto' => 'sometimes|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique'   => 'Username sudah terdaftar',
            'passowrd.required' => 'Password harus diisi',
            'password.confirmed'=> 'Password tidak sama',
            'user_level.required'=> 'User level harus dipilih',
            'user_foto.image'   => 'Harus berupa gambar',
            'user_foto.max'     => 'Ukuran gambar maksimal 2mb'
        ];
    }
}
