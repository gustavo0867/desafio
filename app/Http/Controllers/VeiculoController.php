<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use Carbon\Carbon;


class VeiculoController 
{
    public function index()
    {
        $veiculos = Veiculo::all();
        //dd($veiculos);
        return view('veiculos.index', compact('veiculos'));  // Passa a variável para a view
    }


    public function create()
    {
        return view('veiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            'data_aquisicao' => 'required|date',
            'km_atual' => 'required|integer',
            'km_aquisicao' => 'required|integer',
            'renavam' => 'required|string|regex:/^\d{11}$/|unique:veiculos', // Padrão de 11 dígitos
        'placa' => 'required|string|regex:/^[A-Z]{3}\d[A-Z0-9]\d{2}$/|unique:veiculos', // Padrão Mercosul
        ]);



        // Verifica se a placa já existe
        if (Veiculo::where('placa', $request->placa)->exists()) {
            return redirect()->back()->withErrors(['placa' => 'Esta placa já está cadastrada.'])->withInput();
        }

        // Verifica se o renavam já existe
        if (Veiculo::where('renavam', $request->renavam)->exists()) {
            return redirect()->back()->withErrors(['renavam' => 'Este Renavam já está cadastrado.'])->withInput();
        }

        if (Carbon::parse($request->data_aquisicao)->greaterThan(Carbon::today())) {
            return redirect()->back()->withErrors(['data_aquisicao' => 'A data de aquisição não pode ser posterior ao dia de hoje.'])->withInput();
        }


        // Validação da data de aquisição
        // Verifica se a data do KM atual é menor que a data de aquisição
        if ($request->km_atual < $request->km_aquisicao) {
            return redirect()->back()->withErrors(['km_atual' => 'O KM atual não pode ser menor que o KM de aquisição.'])->withInput();
        }

        Veiculo::create($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    

    public function edit($id)
    {   
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID

        return view('veiculos.edit', compact('veiculo')); // Passa o veículo para a view
        
    }

    public function update(Request $request, $id)
    {
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID

        $request->validate([
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            'data_aquisicao' => 'required|date',
            'km_aquisicao' => 'required|integer',
            'renavam' => 'required|string|regex:/^\d{11}$/|unique:veiculos,renavam,' . $veiculo->id,
            'placa' => 'required|string|regex:/^[A-Z]{3}\d[A-Z0-9]\d{2}$/|unique:veiculos,placa,' . $veiculo->id,
        ]);

        // Verifica se a placa já existe (exceto para o veículo atual)
        if (Veiculo::where('placa', $request->placa)->where('id', '!=', $veiculo->id)->exists()) {
            return redirect()->back()->withErrors(['placa' => 'Esta placa já está cadastrada.'])->withInput();
        }

        // Verifica se o renavam já existe (exceto para o veículo atual)
        if (Veiculo::where('renavam', $request->renavam)->where('id', '!=', $veiculo->id)->exists()) {
            return redirect()->back()->withErrors(['renavam' => 'Este Renavam já está cadastrado.'])->withInput();
        }

        // Validação da data de aquisição
        if (Carbon::parse($request->data_aquisicao)->greaterThan(Carbon::today())) {
            return redirect()->back()->withErrors(['data_aquisicao' => 'A data de aquisição não pode ser posterior ao dia de hoje.'])->withInput();
        }

        // Verifica se a data do KM atual é menor que a data de aquisição
        if ($request->km_atual < $request->km_aquisicao) {
            return redirect()->back()->withErrors(['km_atual' => 'O KM atual não pode ser menor que o KM de aquisição.'])->withInput();
        }
        

        $veiculo->update($request->all());
        //dd($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy($id)
    {   
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID
        $veiculo->delete();

        return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
    }
}
