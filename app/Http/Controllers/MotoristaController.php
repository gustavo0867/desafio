<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MotoristaController 
{
    public function index()
    {
        $motoristas = Motorista::all();
        return view('motoristas.index', compact('motoristas'));
    }

    public function create()
    {
        return view('motoristas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'data_nascimento' => 'required|date',
            'cnh' => 'required|string|unique:motoristas',
        ]);

        // Verificação da idade (maior de 18 anos)
        $dataNascimento = Carbon::parse($request->data_nascimento);
        $idade = $dataNascimento->diffInYears(Carbon::today());

        if ($idade < 18) {
            return redirect()->back()->withErrors(['data_nascimento' => 'O motorista deve ter mais de 18 anos.'])->withInput();
        }

        // Verificação se a CNH já está cadastrada
        if (Motorista::where('cnh', $request->cnh)->exists()) {
            return redirect()->back()->withErrors(['cnh' => 'Esta CNH já está cadastrada.'])->withInput();
        }

        Motorista::create($request->all());

        return redirect()->route('motoristas.index')->with('success', 'Motorista cadastrado com sucesso!');
    }

    

    public function edit($id)
    {   
        $motorista = Motorista::findOrFail($id);
        return view('motoristas.edit', compact('motorista'));
    }

    

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string',
            'data_nascimento' => 'required|date',
            'cnh' => 'required|string|unique:motoristas,cnh,' . $id, // Ignora o motorista atual
        ]);

        // Verificação da idade (maior de 18 anos)
        $dataNascimento = Carbon::parse($request->data_nascimento);
        $idade = $dataNascimento->diffInYears(Carbon::today());

        if ($idade < 18) {
            return redirect()->back()->withErrors(['data_nascimento' => 'O motorista deve ter mais de 18 anos.'])->withInput();
        }

        // Atualiza o motorista
        $motorista = Motorista::find($id);
        $motorista->update($request->all());

        return redirect()->route('motoristas.index')->with('success', 'Motorista atualizado com sucesso!');
    }

    public function destroy($id)
    {   
        $motorista = Motorista::findOrFail($id);
        $motorista->delete();
        return redirect()->route('motoristas.index')->with('success', 'Motorista excluído com sucesso!');
    }
}
