<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipamentoController extends Controller
{
    public function index()
    {
        $equipamentos = Equipamento::latest()->paginate(10); 

        return view('equipamentos.index', compact('equipamentos')); 
    }

    public function paginate(Request $request)
    {
        $q = $request->search;

        $result = Equipamento::join('clientes', 'equipamentos.cliente_id', '=', 'clientes.id')
            ->select('equipamentos.id', DB::raw("CONCAT(clientes.nome, ' (', equipamentos.marca, ' - ', equipamentos.modelo, ')') as text"))
            ->where(function ($query) use ($q) {
                $query->where('clientes.nome', 'like', "%$q%")
                    ->orWhere('equipamentos.marca', 'like', "%$q%")
                    ->orWhere('equipamentos.modelo', 'like', "%$q%");
            })
            ->orderBy('clientes.nome')
            ->paginate(10);

        return response()->json($result);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
