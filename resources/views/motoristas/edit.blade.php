@extends('layouts.app')

@section('content')
    <h1>Editar Motorista</h1>
    <form action="{{ route('motoristas.update', $motorista->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $motorista->nome) }}" required><br><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $motorista->data_nascimento) }}" required>
        @error('data_nascimento')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>

        <label for="cnh">CNH:</label>
        <input type="text" id="cnh" name="cnh" value="{{ old('cnh', $motorista->cnh) }}" required>
        @error('cnh')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br><br>

        <button type="submit">Atualizar Motorista</button>
        <br>
        <br>
       
    </form>
        <a href="{{ route('motoristas.index') }}">
            <button>Voltar</button>
        </a>
@endsection