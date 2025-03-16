@extends('layouts.app')

@section('content')
    <h1>Criar Viagem</h1>

    <form method="POST" action="{{ route('viagens.store') }}">
        @csrf

        <div class="form-group">
            <label for="veiculo_id">Veículo:</label>
            <select id="veiculo_id" name="veiculo_id" class="form-control" required>
                <option value="">Selecione o Veículo</option>
                @foreach($veiculos as $veiculo)
                    <option value="{{ $veiculo->id }}" data-km="{{ $veiculo->km_atual }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                        {{ $veiculo->modelo }} - {{ $veiculo->placa }}
                    </option>
                @endforeach
            </select>
            @error('veiculo_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Exibição do KM Atual -->
        <div class="form-group">
            <label>KM Atual do Veículo:</label>
            <input type="text" id="km_atual" class="form-control" value="" readonly>
        </div>

        <div class="form-group">
            <label for="distancia">Distância (KM):</label>
            <input type="number" id="distancia" name="distancia" class="form-control" value="{{ old('distancia') }}" required>
            @error('distancia')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Exibição do KM Atualizado -->
        <div class="form-group">
            <label>KM Previsto Após a Viagem:</label>
            <input type="text" id="km_atualizado" class="form-control" value="" readonly>
        </div>

        <div class="form-group">
            <label for="data_hora_inicio">Data e Hora de Início:</label>
            <input type="datetime-local" id="data_hora_inicio" name="data_hora_inicio" class="form-control" value="{{ old('data_hora_inicio') }}" required>
            @error('data_hora_inicio')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="data_hora_chegada">Data e Hora de Chegada:</label>
            <input type="datetime-local" id="data_hora_chegada" name="data_hora_chegada" class="form-control" value="{{ old('data_hora_chegada') }}">
            @error('data_hora_chegada')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Escolha os Motoristas (máximo 4):</label><br>
            @foreach($motoristas as $motorista)
                <input type="checkbox" name="motoristas[]" value="{{ $motorista->id }}" 
                    {{ in_array($motorista->id, old('motoristas', [])) ? 'checked' : '' }}>
                <label for="motoristas[]">{{ $motorista->nome }}</label><br>
            @endforeach
            @error('motoristas')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Criar Viagem</button>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const veiculoSelect = document.getElementById("veiculo_id");
            const kmAtualInput = document.getElementById("km_atual");
            const distanciaInput = document.getElementById("distancia");
            const kmAtualizadoInput = document.getElementById("km_atualizado");

            function atualizarKM() {
                const selectedOption = veiculoSelect.options[veiculoSelect.selectedIndex];
                const kmAtual = parseFloat(selectedOption.getAttribute("data-km")) || 0;
                const distancia = parseFloat(distanciaInput.value) || 0;
                
                kmAtualInput.value = kmAtual;
                kmAtualizadoInput.value = kmAtual + distancia;
            }

            veiculoSelect.addEventListener("change", atualizarKM);
            distanciaInput.addEventListener("input", atualizarKM);

            atualizarKM();
        });
    </script>
@endsection
