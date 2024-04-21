<?php

namespace App\Http\Requests\Satuan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSatuanRequest extends FormRequest
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
            'id'        => 'required',
            'nmsatuan'  => 'required|unique:satuan,nmsatuan,' . $this->id
        ];
    }

    public function messages()
    {
        return [
            'nmsatuan.required' => 'Nama Satuan harus diisi',
            'nmsatuan.unique'   => 'Nama Satuan sudah terdaftar'
        ];
    }
}
