<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => ['required', Rule::unique('contatos')->ignore($this->nome)],
            'numero_telefone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Preencha o campo nome',
            'numero_telefone.required' => 'Insira ao menos um número de telefone'
        ];
    }
}
