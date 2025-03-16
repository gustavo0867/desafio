<?php
namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMotoristaRequest;
use App\Http\Requests\UpdateMotoristaRequest;
use Carbon\Carbon;

class MotoristaController 
{
    // Exibe todos os motoristas
    public function index()
    {
        $motoristas = Motorista::all(); // Busca todos os motoristas
        return view('motoristas.index', compact('motoristas'));
    }

    // Exibe o formulário para criar um motorista
    public function create()
    {
        return view('motoristas.create'); // Retorna a view para criar um motorista
    }

    // Armazena um novo motorista no banco de dados
    public function store(StoreMotoristaRequest $request)
    {
        // Validação já feita no StoreMotoristaRequest

        // Verificação da idade (motorista deve ter mais de 18 anos)
        $dataNascimento = Carbon::parse($request->data_nascimento);
        $idade = $dataNascimento->diffInYears(Carbon::today());

        if ($idade < 18) {
            return redirect()->back()->withErrors(['data_nascimento' => 'O motorista deve ter mais de 18 anos.'])->withInput();
        }

        // Cria o novo motorista
        Motorista::create($request->validated());

        return redirect()->route('motoristas.index')->with('success', 'Motorista cadastrado com sucesso!');
    }

    // Exibe o formulário para editar um motorista
    public function edit($id)
    {
        $motorista = Motorista::findOrFail($id); // Busca o motorista pelo ID
        return view('motoristas.edit', compact('motorista')); // Retorna a view de edição com os dados do motorista
    }

    // Atualiza um motorista existente no banco de dados
    public function update(UpdateMotoristaRequest $request, $id)
    {
        // Validação já feita no UpdateMotoristaRequest

        // Verificação da idade (motorista deve ter mais de 18 anos)
        $dataNascimento = Carbon::parse($request->data_nascimento);
        $idade = $dataNascimento->diffInYears(Carbon::today());

        if ($idade < 18) {
            return redirect()->back()->withErrors(['data_nascimento' => 'O motorista deve ter mais de 18 anos.'])->withInput();
        }

        // Atualiza o motorista
        $motorista = Motorista::findOrFail($id);
        $motorista->update($request->validated());

        return redirect()->route('motoristas.index')->with('success', 'Motorista atualizado com sucesso!');
    }

    // Exclui um motorista do banco de dados
    public function destroy($id)
    {
        $motorista = Motorista::findOrFail($id); // Busca o motorista pelo ID
        $motorista->delete(); // Exclui o motorista

        return redirect()->route('motoristas.index')->with('success', 'Motorista excluído com sucesso!');
    }
}
