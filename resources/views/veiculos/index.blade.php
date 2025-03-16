@extends('layouts.app')

@section('content')
    <h1>Veículos</h1>
    <a href="{{ route('veiculos.create') }}">Criar Novo Veículo</a>
    <table>
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Renavam</th>
                <th>Placa</th>
                <th>Data Aquisição</th>
                <th>Km Atual</th>
                <th>Km Aquisição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($veiculos as $veiculo)
                <tr>
                    <td>{{ $veiculo->modelo }}</td>
                    <td>{{ $veiculo->ano }}</td>
                    <td>{{ $veiculo->renavam }}</td>
                    <td>{{ $veiculo->placa }}</td>
                    <td>{{ $veiculo->data_aquisicao }}</td>
                    <td>{{ $veiculo->km_atual }}</td>
                    <td>{{ $veiculo->km_aquisicao }}</td>
                    <td>
                        
                        <a href="{{ route('veiculos.edit', $veiculo->id) }}">Editar</a>
                        <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
