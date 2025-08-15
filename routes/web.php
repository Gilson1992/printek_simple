<?php

use App\Http\Controllers\{ClienteController, EquipamentoController, OrdemServicoController, TecnicoController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('clientes/paginate', [ClienteController::class, 'paginate'])->name('clientes.paginate');
Route::resource('clientes', ClienteController::class);
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('ordens-servico', OrdemServicoController::class);
Route::resource('tecnicos', TecnicoController::class);
