<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLegacyUserRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255'],
            'senha' => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:8', 'max:255'],
            'status' => ['nullable', 'in:ATIVO,INATIVO'],
            'unidade' => ['nullable', 'string', 'max:255'],
            'desc_nivel' => ['required', Rule::in(['Administrador', 'Usuario'])],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'cod_nivel' => $this->input('desc_nivel') === 'Administrador' ? '0' : '1',
        ]);
    }
}
