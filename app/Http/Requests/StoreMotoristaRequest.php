<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMotoristaRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'nome' => 'required|string',
            'data_nascimento' => 'required|date',
            'cnh' => 'required|string|unique:motoristas',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome do motorista é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'cnh.required' => 'A CNH é obrigatória.',
            'cnh.unique' => 'Esta CNH já está cadastrada.',
        ];
    }
}
