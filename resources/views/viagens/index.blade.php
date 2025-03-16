@extends('layouts.app')

@section('content')
    <h1>Viagens</h1>

    <!-- Links para cadastro de veículos e motoristas -->
    <div class="mb-3">
        <a href="{{ route('veiculos.index') }}" class="btn btn-success">Veículos</a>
        <a href="{{ route('motoristas.index') }}" class="btn btn-primary">Motoristas</a>
    </div>

    <div class="mb-3">
        <a href="{{ route('viagens.create') }}" class="btn btn-secondary">Criar Viagem</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Veículo</th>
                <th>Distância</th>
                <th>Data de Início</th>
                <th>Data de Chegada</th>
                <th>Motoristas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viagens as $viagem)
                <tr>
                    <td>{{ $viagem->id }}</td>
                    <td>{{ $viagem->veiculo->modelo }} - {{ $viagem->veiculo->placa }}</td>
                    <td>{{ $viagem->distancia }} km</td>
                    <td>{{ $viagem->data_hora_inicio }}</td>
                    <td>{{ $viagem->data_hora_chegada }}</td>
                    <td>
                        @foreach($viagem->motoristas as $motorista)
                            {{ $motorista->nome }}<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('viagens.edit', $viagem->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('viagens.destroy', $viagem->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta viagem?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
     <!-- Adiciona a paginação, caso esteja utilizando paginamento -->
@endsection
