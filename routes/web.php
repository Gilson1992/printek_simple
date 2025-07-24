<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\OrdemServicoController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard'); // Demos um nome à rota para referência futura

Route::resource('clientes', ClienteController::class);
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('ordens-servico', OrdemServicoController::class);