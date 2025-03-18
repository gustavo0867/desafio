<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreVeiculoRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            'data_aquisicao' => 'required|date',
            'km_atual' => 'required|integer',
            'km_aquisicao' => 'required|integer',
            'renavam' => 'required|string|regex:/^\d{11}$/|unique:veiculos',
            'placa' => 'required|string|regex:/^[A-Z]{3}\d[A-Z0-9]\d{2}$/|unique:veiculos',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Captura a data de aquisição como string
            $dataAquisicao = $this->input('data_aquisicao');

            // Verifica se a data de aquisição é posterior ao dia de hoje
            if (Carbon::parse($dataAquisicao)->greaterThan(Carbon::today())) {
                $validator->errors()->add('data_aquisicao', 'A data de aquisição não pode ser posterior ao dia de hoje.');
            }

            // Verifica se a quilometragem atual é menor que a quilometragem de aquisição
            if ($this->km_atual < $this->km_aquisicao) {
                $validator->errors()->add('km_atual', 'O KM atual não pode ser menor que o KM de aquisição.');
            }
        });
    }
}
