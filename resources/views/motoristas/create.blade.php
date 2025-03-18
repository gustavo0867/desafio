@extends('layouts.app')

@section('content')
    <div class="content-container">
        <h1>Criar Novo Motorista</h1>
        <form action="{{ route('motoristas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required class="form-control"><br><br>
            </div>

            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required class="form-control">
                @error('data_nascimento')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <label for="cnh">CNH:</label>
                <input type="text" id="cnh" name="cnh" value="{{ old('cnh') }}" required class="form-control">
                @error('cnh')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br><br>
            </div>

            <div class="form-group">
                <button type="submit" class="link-button">Criar Motorista</button>
            </div>
        </form>
        <br>
        <div>
            <a href="{{ route('motoristas.index') }}" class="link-button">Voltar</a>
        </div>
    </div>
@endsection

<style>
    .form-group {
        margin-bottom: 0.1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #4b5563;
        font-weight: 500;
    }

    .form-group input[type="text"],
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