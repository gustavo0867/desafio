@extends('layouts.app')

@section('content')
    <div class="container">

    <div class="header-container">
        <h1>Lista de Motoristas</h1>
        <a href="{{ route('motoristas.create') }}" class="create-btn">+ Novo Motorista</a>
    </div>


        
        
        <div class="table-container">
            <table class="padrao-table">
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
                            <td>{{ \Carbon\Carbon::parse($motorista->data_nascimento)->format('d/m/Y') }}</td>
                            <td>{{ $motorista->cnh }}</td>
                            <td class="acoes-column">
                                <div>
                                    <a href="{{ route('motoristas.edit', $motorista->id) }}" class="edit-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                        </svg>
                                    </a>
                                </div>
                                <form action="{{ route('motoristas.destroy', $motorista->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este motorista?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M5 6h14l-1 14H6L5 6z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
