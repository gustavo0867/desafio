@extends('layouts.app')

@section('content')
    <h1>Editar Viagem</h1>

    <form method="POST" action="{{ route('viagens.update', $viagem->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="veiculo_id">Veículo:</label>
            <select id="veiculo_id" name="veiculo_id" class="form-control" required>
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
            <input type="number" id="distancia" name="distancia" class="form-control" value="{{ old('distancia', $viagem->distancia) }}" required>
            @error('distancia')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="data_hora_inicio">Data e Hora de Início:</label>
            <input type="datetime-local" id="data_hora_inicio" name="data_hora_inicio" class="form-control" value="{{ old('data_hora_inicio', \Carbon\Carbon::parse($viagem->data_hora_inicio)->format('Y-m-d\TH:i')) }}" required>
            @error('data_hora_inicio')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="data_hora_chegada">Data e Hora de Chegada:</label>
            <input type="datetime-local" id="data_hora_chegada" name="data_hora_chegada" class="form-control" value="{{ old('data_hora_chegada', \Carbon\Carbon::parse($viagem->data_hora_chegada)->format('Y-m-d\TH:i')) }}">
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
            <button type="submit" class="btn btn-primary">Atualizar Viagem</button>
        </div>
    </form>
@endsection
