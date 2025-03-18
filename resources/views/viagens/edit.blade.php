@extends('layouts.app')

@section('content')
    <div class="content-container">
        <h1>Editar Viagem</h1>

        <form method="POST" action="{{ route('viagens.update', $viagem->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="veiculo_id">Veículo:</label>
                <select id="veiculo_id" name="veiculo_id" required class="form-control">
                    <option value="">Selecione o Veículo</option>
                    @foreach($veiculos as $veiculo)
                        <option value="{{ $veiculo->id }}" {{ old('veiculo_id', $viagem->veiculo_id) == $veiculo->id ? 'selected' : '' }}>
                            {{ $veiculo->modelo }} - {{ $veiculo->placa }}
                        </option>
                    @endforeach
                </select>
                @error('veiculo_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="distancia">Distância:</label>
                <input type="number" id="distancia" name="distancia" value="{{ old('distancia', $viagem->distancia) }}" required class="form-control">
                @error('distancia')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="data_hora_inicio">Data e Hora de Início:</label>
                <input type="datetime-local" id="data_hora_inicio" name="data_hora_inicio" value="{{ old('data_hora_inicio', \Carbon\Carbon::parse($viagem->data_hora_inicio)->format('Y-m-d\TH:i')) }}" required class="form-control">
                @error('data_hora_inicio')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="data_hora_chegada">Data e Hora de Chegada:</label>
                <input type="datetime-local" id="data_hora_chegada" name="data_hora_chegada" value="{{ old('data_hora_chegada', \Carbon\Carbon::parse($viagem->data_hora_chegada)->format('Y-m-d\TH:i')) }}" class="form-control">
                @error('data_hora_chegada')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Escolha os Motoristas (máximo 4):</label><br>
                @foreach($motoristas as $motorista)
                    <input type="checkbox" name="motoristas[]" value="{{ $motorista->id }}"
                        {{ in_array($motorista->id, old('motoristas', $viagem->motoristas->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label for="motoristas[]">{{ $motorista->nome }}</label><br>
                @endforeach
                @error('motoristas')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="link-button">Atualizar Viagem</button>
            </div>
        </form>
    </div>
@endsection

<style>
    /* Estilos específicos para este formulário */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #4b5563;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="date"],
    .form-group input[type="datetime-local"],
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #374151;
        box-sizing: border-box;
    }

    .form-group input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .form-group .alert-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>