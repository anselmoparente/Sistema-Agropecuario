<?php

namespace App\Http\Requests;

use App\Models\UnidadeProducao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUnidadeProducaoRequest extends FormRequest
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
            'nome_cultura' => ['required', 'string', 'max:255', Rule::in(UnidadeProducao::CULTURAS)],
            'area_total_ha' => ['nullable', 'numeric', 'min:0'],
            'coordenadas_geograficas' => ['nullable', 'string', 'max:255'],
            'propriedade_id' => ['required', 'exists:propriedades,id'],
        ];
    }
}
