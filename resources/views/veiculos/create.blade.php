@extends('layouts.app')

@section('content')
    <h1>Criar Novo Veículo</h1>
    <form action="{{ route('veiculos.store') }}" method="POST">
        @csrf

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" required><br><br>

        <label for="ano">Ano:</label>
        <input type="number" id="ano" name="ano" value="{{ old('ano') }}" required><br><br>

        <label for="renavam">Renavam:</label>
        <input type="text" id="renavam" name="renavam" value="{{ old('renavam') }}" required>
        @error('renavam')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>

        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" value="{{ old('placa') }}" required>
        @error('placa')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>

        <label for="data_aquisicao">Data de Aquisição:</label>
        <input type="date" id="data_aquisicao" name="data_aquisicao" value="{{ old('data_aquisicao') }}" required><br><br>
        @error('data_aquisicao')
             <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>
        

        <label for="km_atual">KM Atual:</label>
        <input type="number" id="km_atual" name="km_atual" value="{{ old('km_atual') }}" required>
        @error('km_atual')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>

        <label for="km_aquisicao">KM Aquisição:</label>
        <input type="number" id="km_aquisicao" name="km_aquisicao" value="{{ old('km_aquisicao') }}" required><br><br>

        <button type="submit">Criar Veículo</button>
        
    </form>
    <br>
    <a href="{{ route('veiculos.index') }}"> 
            <button>Voltar</button>
    </a>
@endsection