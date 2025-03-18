<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVeiculoRequest;
use App\Http\Requests\UpdateVeiculoRequest;

class VeiculoController 
{
    // Exibe todos os veículos
    public function index()
    {
        $veiculos = Veiculo::all(); // Busca todos os veículos
        return view('veiculos.index', compact('veiculos'));
    }

    // Exibe o formulário para criar um novo veículo
    public function create()
    {
        return view('veiculos.create'); // Retorna a view de criação
    }

    // Armazena um novo veículo no banco de dados
    public function store(StoreVeiculoRequest $request)
    {
        Veiculo::create($request->validated()); // Cria o veículo com os dados validados

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    // Exibe o formulário para editar um veículo
    public function edit($id)
    {
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID
        return view('veiculos.edit', compact('veiculo')); // Retorna a view de edição
    }


    public function update(UpdateVeiculoRequest $request, $id)
    {
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID
        $novaQuilometragem = $request->input('km_atual');

        // Verifica se o veículo já tem viagens registradas
        $temViagens = $veiculo->viagens()->exists(); 

        // Se o veículo tem viagens e a nova quilometragem for menor que a atual ou maior, bloqueia a alteração
        if ($temViagens && $novaQuilometragem < $veiculo->km_atual || $temViagens && $novaQuilometragem > $veiculo->km_atual ) {
            return redirect()->back()->with('error', 'Não é possível reduzir a quilometragem de um veículo já utilizado em viagens.');
        }

        // Atualiza normalmente
        $veiculo->update($request->validated());

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }


    // Exclui um veículo do banco de dados
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID
        $veiculo->delete(); // Exclui o veículo

        return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
    }
}
