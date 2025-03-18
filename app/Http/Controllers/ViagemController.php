<?php

namespace App\Http\Controllers;

use App\Models\Viagem;
use App\Models\Motorista;
use App\Models\Veiculo;
use App\Http\Requests\UpdateViagemRequest;
use App\Http\Requests\StoreViagemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ViagemController
{
    public function index()
    {
        $viagens = Viagem::with('motoristas', 'veiculo')->get();
        return view('viagens.index', compact('viagens'));
    }

    
    public function create()
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::all();
        return view('viagens.create', compact('motoristas', 'veiculos'));
    }


    public function store(Request $request)
    {
        // Validação
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'distancia' => 'required|integer|min:0',
            'data_hora_inicio' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'data_hora_chegada' => 'nullable|date|after:data_hora_inicio',
            'motoristas' => 'required|array|min:1|max:4',
            'motoristas.*' => 'exists:motoristas,id',
        ]);
        
        // Verificar se o veículo já está ocupado no mesmo intervalo de tempo
        $veiculoOcupado = \DB::table('viagens')
            ->where('veiculo_id', $request->veiculo_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('data_hora_inicio', [$request->data_hora_inicio, $request->data_hora_chegada]) // Se o início da viagem atual estiver no intervalo de outra viagem
                    ->orWhereBetween('data_hora_chegada', [$request->data_hora_inicio, $request->data_hora_chegada]) // Se a chegada da viagem atual estiver no intervalo de outra viagem
                    ->orWhere(function ($query) use ($request) {
                        $query->where('data_hora_inicio', '<', $request->data_hora_inicio)
                                ->where('data_hora_chegada', '>', $request->data_hora_chegada); // Se a viagem atual ocorrer completamente dentro do intervalo de outra
                    });
            })
            ->exists();

        if ($veiculoOcupado) {
            return redirect()->back()->withErrors(['veiculo_id' => 'O veículo selecionado já está sendo utilizado nesse período.'])->withInput();
        }

        // Verificar se algum dos motoristas está ocupado
        $motoristasOcupados = [];
        foreach ($request->motoristas as $motoristaId) {
            $motorista = Motorista::find($motoristaId);
            $motoristaOcupado = DB::table('motorista_viagem')
                ->join('viagens', 'motorista_viagem.viagem_id', '=', 'viagens.id')
                ->where('motorista_viagem.motorista_id', $motoristaId)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('viagens.data_hora_inicio', [$request->data_hora_inicio, $request->data_hora_chegada])
                        ->orWhereBetween('viagens.data_hora_chegada', [$request->data_hora_inicio, $request->data_hora_chegada]);
                })
                ->exists();

            if ($motoristaOcupado) {
                $motoristasOcupados[] = $motorista->nome;
            }
        }

        // Se algum motorista estiver ocupado, retorna a mensagem com os nomes
        if (!empty($motoristasOcupados)) {
            return redirect()->back()->withErrors(['motoristas' => 'Os seguintes motoristas estão ocupados nesse período: ' . implode(', ', $motoristasOcupados)])->withInput();
        }

        // Código para salvar a viagem após a validação
        DB::transaction(function () use ($request) {
            $veiculo = Veiculo::findOrFail($request->veiculo_id);

            // Criar viagem
            $viagem = Viagem::create([
                'veiculo_id' => $request->veiculo_id,
                'distancia' => $request->distancia,
                'data_hora_inicio' => $request->data_hora_inicio,
                'data_hora_chegada' => $request->data_hora_chegada,
            ]);

            // Associar motoristas
            $viagem->motoristas()->attach($request->motoristas);

            // Atualizar KM do veículo
            $veiculo->update([
                'km_atual' => $veiculo->km_atual + $request->distancia,
            ]);
        });

        return redirect()->route('viagens.index')->with('success', 'Viagem criada com sucesso!');
    }


    public function edit($id)
    {
        $viagem = Viagem::with('motoristas')->findOrFail($id);
        $motoristas = Motorista::all();
        $veiculos = Veiculo::all();
        return view('viagens.edit', compact('viagem', 'motoristas', 'veiculos'));
    }

    
    public function update(UpdateViagemRequest $request, $id)
    {
        // Encontrar a viagem
        $viagem = Viagem::findOrFail($id);

        // Verifica se o veículo está disponível
        $veiculoOcupado = \DB::table('viagens')
            ->where('veiculo_id', $request->veiculo_id)
            ->where('id', '<>', $viagem->id) // Exclui a própria viagem
            ->where(function ($query) use ($request) {
                $query->whereBetween('data_hora_inicio', [$request->data_hora_inicio, $request->data_hora_chegada])
                    ->orWhereBetween('data_hora_chegada', [$request->data_hora_inicio, $request->data_hora_chegada])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('data_hora_inicio', '<', $request->data_hora_inicio)
                                ->where('data_hora_chegada', '>', $request->data_hora_chegada);
                    });
            })
            ->exists();

        if ($veiculoOcupado) {
            return redirect()->back()->withErrors(['veiculo_id' => 'O veículo selecionado já está sendo utilizado nesse período.'])->withInput();
        }

        // Verificar se algum dos motoristas está ocupado
        $motoristasOcupados = [];
        foreach ($request->motoristas as $motoristaId) {
            $motorista = Motorista::find($motoristaId);
            $motoristaOcupado = DB::table('motorista_viagem')
                ->join('viagens', 'motorista_viagem.viagem_id', '=', 'viagens.id')
                ->where('motorista_viagem.motorista_id', $motoristaId)
                ->where('viagens.id', '<>', $viagem->id) // Verifica outras viagens, exceto a atual
                ->where(function ($query) use ($request) {
                    $query->whereBetween('viagens.data_hora_inicio', [$request->data_hora_inicio, $request->data_hora_chegada])
                        ->orWhereBetween('viagens.data_hora_chegada', [$request->data_hora_inicio, $request->data_hora_chegada]);
                })
                ->exists();

            if ($motoristaOcupado) {
                $motoristasOcupados[] = $motorista->nome;
            }
        }

        // Se algum motorista estiver ocupado, retorna a mensagem com os nomes
        if (!empty($motoristasOcupados)) {
            return redirect()->back()->withErrors(['motoristas' => 'Os seguintes motoristas estão ocupados nesse período: ' . implode(', ', $motoristasOcupados)])->withInput();
        }


        DB::transaction(function () use ($request, $viagem) {
            // Pega o veículo antigo da viagem
            $veiculoAntigo = Veiculo::findOrFail($viagem->veiculo_id);

            // Reverter o KM do veículo antigo
            $veiculoAntigo->update([
                'km_atual' => $veiculoAntigo->km_atual - $viagem->distancia,
            ]);

            // Pega o novo veículo
            $veiculoNovo = Veiculo::findOrFail($request->veiculo_id);

            // Atualiza a viagem com o novo veículo
            $viagem->update([
                'veiculo_id' => $request->veiculo_id,
                'distancia' => $request->distancia,
                'data_hora_inicio' => $request->data_hora_inicio,
                'data_hora_chegada' => $request->data_hora_chegada,
            ]);

            // Atualizar motoristas associados
            $viagem->motoristas()->sync($request->motoristas);

            // Atualiza o KM do novo veículo
            $veiculoNovo->update([
                'km_atual' => $veiculoNovo->km_atual + $request->distancia,
            ]);
        });

        return redirect()->route('viagens.index')->with('success', 'Viagem atualizada com sucesso!');
    }


    public function destroy($id)
    {
        $viagem = Viagem::findOrFail($id);

        DB::transaction(function () use ($viagem) {
            $veiculo = Veiculo::findOrFail($viagem->veiculo_id);

            // Reverter o KM do veículo antes de excluir a viagem
            $veiculo->update([
                'km_atual' => $veiculo->km_atual - $viagem->distancia,
            ]);

            // Remover motoristas associados
            $viagem->motoristas()->detach();

            // Deletar viagem
            $viagem->delete();
        });

        return redirect()->route('viagens.index')->with('success', 'Viagem excluída com sucesso!');
    }
}
