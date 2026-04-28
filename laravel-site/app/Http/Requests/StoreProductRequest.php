<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prod_name' => ['required', 'string', 'max:255'],
            'prod_desc' => ['nullable', 'string', 'max:1000'],
            'prod_price' => ['required', 'numeric', 'min:0'],
            'prod_qtde' => ['required', 'integer', 'min:0'],
            'prod_family' => ['required', Rule::in(['Alimentos', 'Produtos de Limpeza', 'Produtos de Revenda', 'Outros'])],
            'prod_valid' => ['nullable', 'date'],
            'prod_foto' => ['nullable', 'url', 'max:1000'],
            'prod_status' => ['nullable', 'in:ATIVO,INATIVO'],
        ];
    }
}
