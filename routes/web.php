<?php

use App\Http\Controllers\{ClienteController, EquipamentoController, OrdemServicoController, PecaController, ServicoController, TecnicoController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('clientes/paginate', [ClienteController::class, 'paginate'])->name('clientes.paginate');
Route::get('equipamentos/paginate', [EquipamentoController::class, 'paginate'])->name('equipamentos.paginate');
Route::get('tecnicos/paginate', [TecnicoController::class, 'paginate'])->name('tecnicos.paginate');
Route::get('servicos/paginate', [ServicoController::class, 'paginate'])->name('servicos.paginate');
Route::get('pecas/paginate', [PecaController::class, 'paginate'])->name('pecas.paginate');

Route::resource('clientes', ClienteController::class);
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('ordens-servico', OrdemServicoController::class);
Route::resource('pecas', PecaController::class);
Route::resource('servicos', ServicoController::class);
Route::resource('tecnicos', TecnicoController::class);
