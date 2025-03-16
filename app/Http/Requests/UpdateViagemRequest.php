<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateViagemRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriza todas as requisições
    }

    public function rules()
    {
        $viagemId = $this->route('viagem'); // Pega o ID da viagem na URL
        
        return [
            'veiculo_id' => 'required|exists:veiculos,id',
            'distancia' => 'required|integer|min:0',
            'data_hora_inicio' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'data_hora_chegada' => 'nullable|date|after:data_hora_inicio',
            'motoristas' => 'required|array|min:1|max:4',
            'motoristas.*' => 'exists:motoristas,id',
        ];
    }
}
