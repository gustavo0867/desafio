@extends('layouts.app')

@section('content')
    <div class="content-container">
        <h1>Editar Veículo</h1>
        <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" value="{{ old('modelo', $veiculo->modelo) }}" required class="form-control"><br><br>
            </div>

            <div class="form-group">
                <label for="ano">Ano:</label>
                <input type="number" id="ano" name="ano" value="{{ old('ano', $veiculo->ano) }}" required class="form-control"><br><br>
            </div>

            <div class="form-group">
                <label for="renavam">Renavam:</label>
                <input type="text" id="renavam" name="renavam" value="{{ old('renavam', $veiculo->renavam) }}" required class="form-control">
                @error('renavam')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" value="{{ old('placa', $veiculo->placa) }}" required class="form-control">
                @error('placa')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <label for="data_aquisicao">Data de Aquisição:</label>
                <input type="date" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao', $veiculo->data_aquisicao) }}" required class="form-control"><br><br>
                @error('data_aquisicao')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <label for="km_atual">KM Atual:</label>
                <input type="number" id="km_atual" name="km_atual" value="{{ old('km_atual', $veiculo->km_atual) }}" required class="form-control">
                @error('km_atual')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <label for="km_aquisicao">KM Aquisição:</label>
                <input type="number" id="km_aquisicao" name="km_aquisicao" value="{{ old('km_aquisicao', $veiculo->km_aquisicao) }}" required class="form-control"><br><br>
            </div>

            <div class="form-group">
                <button type="submit" class="link-button">Atualizar Veículo</button>
                <br><br>
            </div>

        </form>

        <div>
            <a href="{{ route('veiculos.index') }}" class="link-button">Voltar</a>
        </div>
    </div>
@endsection

<style>
    
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
    .form-group input[type="date"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #374151;
        box-sizing: border-box;
    }

    .form-group .alert-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>