<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'ord_name' => ['required', 'string', 'max:255'],
            'ord_desc' => ['nullable', 'string', 'max:1000'],
            'ord_value' => ['required', 'numeric', 'min:0'],
            'ord_status' => ['required', Rule::in(['ABERTA', 'EM COTACAO', 'COMPRADA', 'CANCELADA'])],
            'ord_date' => ['required', 'date'],
        ];
    }
}
