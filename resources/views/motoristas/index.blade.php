@extends('layouts.app')

@section('content')
    <h1>Motoristas</h1>
    <a href="{{ route('motoristas.create') }}">Criar Novo Motorista</a>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>CNH</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motoristas as $motorista)
                <tr>
                    <td>{{ $motorista->nome }}</td>
                    <td>{{ $motorista->data_nascimento }}</td>
                    <td>{{ $motorista->cnh }}</td>
                    <td>
                        <a href="{{ route('motoristas.edit', $motorista->id) }}">Editar</a>
                        <form action="{{ route('motoristas.destroy', $motorista->id) }}" method="POST">
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