<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'id'        => 'required|exists:barang,id',
            'kdbrg'     => 'required|unique:barang,kdbrg,'.$this->id,
            'nmbrg'     => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'stock'     => 'required|numeric|min:0',
            'id_satuan' => 'required|exists:satuan,id'
        ];
    }

    public function messages()
    {
        return [
            'kdbrg.required'    => 'Kode Barang harus diisi',
            'kdbrg.unique'      => 'Kode barang sudah ada',
            'nmbrg.required'    => 'Nama Barang harus diisi',
            'nmbrg.string'      => 'Nama Barang harus berupa alphanumeric',
            'harga.required'    => 'Harga harus diisi',
            'harga.numeric'     => 'Harga harus dalam bentuk angka',
            'harga.min'         => 'Harga harus lebih besar dari 0',
            'stock.required'    => 'Stok harus diisi',
            'stock.numeric'     => 'Stok harus dalam bentuk angka',
            'stock.min'         => 'Stok harus lebih besar dari 0',
            'id_satuan.required'=> 'Satuan harus dipilih',
            'id_satuan.exists'  => 'Satuan tidak ditemukan',
        ];
    }
}
