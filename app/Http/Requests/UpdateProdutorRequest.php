<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdutorRequest extends FormRequest
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
        $id = $this->route('produtor');

        return [
            'nome' => ['sometimes', 'required', 'string', 'max:255'],
            'cpf_cnpj' => ['sometimes', 'required', 'string', 'max:20', Rule::unique('produtores', 'cpf_cnpj')->ignore($id)],
            'telefone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'endereco' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
