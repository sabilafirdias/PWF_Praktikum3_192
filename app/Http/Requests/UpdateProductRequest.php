<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
            'name'  => 'required|string|max:255',
            'qty'   => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Nama produk tidak boleh kosong.',
            'name.max'       => 'Nama produk maksimal 255 karakter.',
            
            'qty.required'   => 'Jumlah stok harus diisi.',
            'qty.integer'    => 'Stok harus berupa angka bulat.',
            'qty.min'        => 'Stok tidak boleh kurang dari 0.',
            
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric'  => 'Harga harus berupa angka.',
            'price.min'      => 'Harga tidak boleh kurang dari 0.',
        ];
    }
}
