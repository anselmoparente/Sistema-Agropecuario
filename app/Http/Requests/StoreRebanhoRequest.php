<?php

namespace App\Http\Requests;

use App\Models\Rebanho;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRebanhoRequest extends FormRequest
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
            'especie' => ['required','string','max:100', Rule::in(Rebanho::ESPECIES)],
            'quantidade' => ['required','integer','min:0'],
            'finalidade' => ['nullable','string','max:255'],
            'data_atualizacao' => ['nullable','date'],
            'propriedade_id' => ['required','exists:propriedades,id'],
        ];
    }
}
