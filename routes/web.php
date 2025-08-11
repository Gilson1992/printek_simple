<?php

use App\Http\Controllers\{ClienteController, EquipamentoController, OrdemServicoController, TecnicoController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard'); // Demos um nome à rota para referência futura

Route::resource('clientes', ClienteController::class);
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('ordens-servico', OrdemServicoController::class);
Route::resource('tecnicos', TecnicoController::class);
