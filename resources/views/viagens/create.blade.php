@extends('layouts.app')

@section('content')
    <div class="content-container">
        <h1>Criar Viagem</h1>

        <form method="POST" action="{{ route('viagens.store') }}">
            @csrf

            <div class="form-group">
                <label for="veiculo_id">Veículo:</label>
                <select id="veiculo_id" name="veiculo_id" required class="form-control">
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

            <div class="form-group">
                <label>KM Atual do Veículo:</label>
                <input type="text" id="km_atual" value="" readonly class="form-control">
            </div>

            <div class="form-group">
                <label for="distancia">Distância (KM):</label>
                <input type="number" id="distancia" name="distancia" value="{{ old('distancia') }}" required class="form-control">
                @error('distancia')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>KM Previsto Após a Viagem:</label>
                <input type="text" id="km_atualizado" value="" readonly class="form-control">
            </div>

            <div class="form-group">
                <label for="data_hora_inicio">Data e Hora de Início:</label>
                <input type="datetime-local" id="data_hora_inicio" name="data_hora_inicio" value="{{ old('data_hora_inicio') }}" required class="form-control">
                @error('data_hora_inicio')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="data_hora_chegada">Data e Hora de Chegada:</label>
                <input type="datetime-local" id="data_hora_chegada" name="data_hora_chegada" value="{{ old('data_hora_chegada') }}" class="form-control">
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
                <button type="submit" class="link-button">Criar Viagem</button>
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
    </div>
@endsection

<style>
    
    .form-group {
        margin-bottom: 1.0rem;
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
        padding: 0.50rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #374151;
        box-sizing: border-box


    .form-group input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .form-group .alert-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>