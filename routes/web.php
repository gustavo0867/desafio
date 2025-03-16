<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RelatorioController;


Route::get('/', function () {
    return redirect()->route('viagens.index');
});



Route::prefix('veiculos')->group(function(){
    Route::get('/', [VeiculoController::class, 'index'])->name('veiculos.index'); //listar 
    Route::post('/', [VeiculoController::class, 'store'])->name('veiculos.store'); //salvar 
    Route::get('/create', [VeiculoController::class, 'create'])->name('veiculos.create'); //view de criacao  
    Route::get('/{id}/edit', [VeiculoController::class, 'edit'])->where('id', '[0-9]+')->name('veiculos.edit'); //passa o id e mostra preenchido 
    Route::put('/{id}', [VeiculoController::class, 'update'])->where('id', '[0-9]+')->name('veiculos.update'); //atualiza 
    Route::delete('/{id}', [VeiculoController::class, 'destroy'])->where('id', '[0-9]+')->name('veiculos.destroy'); //deletar 
});


Route::prefix('motoristas')->group(function(){
    Route::get('/', [MotoristaController::class, 'index'])->name('motoristas.index'); //listar 
    Route::post('/', [MotoristaController::class, 'store'])->name('motoristas.store'); //salvar 
    Route::get('/create', [MotoristaController::class, 'create'])->name('motoristas.create'); //view de criacao  
    Route::get('/{id}/edit', [MotoristaController::class, 'edit'])->where('id', '[0-9]+')->name('motoristas.edit'); //passa o id e mostra preenchido 
    Route::put('/{id}', [MotoristaController::class, 'update'])->where('id', '[0-9]+')->name('motoristas.update'); //atualiza 
    Route::delete('/{id}', [MotoristaController::class, 'destroy'])->where('id', '[0-9]+')->name('motoristas.destroy'); //deletar 
});


Route::prefix('viagens')->group(function(){
    Route::get('/', [ViagemController::class, 'index'])->name('viagens.index'); //listar 
    Route::post('/', [ViagemController::class, 'store'])->name('viagens.store'); //salvar 
    Route::get('/create', [ViagemController::class, 'create'])->name('viagens.create'); //view de criacao  
    Route::get('/{id}/edit', [ViagemController::class, 'edit'])->where('id', '[0-9]+')->name('viagens.edit'); //passa o id e mostra preenchido 
    Route::put('/{id}', [ViagemController::class, 'update'])->where('id', '[0-9]+')->name('viagens.update'); //atualiza 
    Route::delete('/{id}', [ViagemController::class, 'destroy'])->where('id', '[0-9]+')->name('viagens.destroy'); //deletar 
});



