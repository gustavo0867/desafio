@extends('layouts.app')

@section('content')
    <div class="container">
        
    <div class="header-container">
        <h1>Lista de Viagens</h1>
        <a href="{{ route('viagens.create') }}" class="create-btn">+ Nova Viagem</a>
    </div>

        <div class="table-container">
            <table class="padrao-table">
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
                            <td>{{ \Carbon\Carbon::parse($viagem->data_hora_inicio)->format('d/m/Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($viagem->data_hora_chegada)->format('d/m/Y H:i') }}</td>
                            <td class="motoristas-column">
                                @foreach($viagem->motoristas as $motorista)
                                    <span>{{ $motorista->nome }}</span>
                                @endforeach
                            </td>
                            <td class="acoes-column">
                                <div>
                                    <a href="{{ route('viagens.edit', $viagem->id) }}" class="edit-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                        </svg>
                                    </a>
                                </div>
                                <form action="{{ route('viagens.destroy', $viagem->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta viagem?')">
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