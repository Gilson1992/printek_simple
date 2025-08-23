<?php

namespace App\Http\Controllers;

use App\Enums\Disponibilidade;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TecnicoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::latest()->paginate(10);

        return view('tecnicos.index', compact('tecnicos'));
    }

    public function paginate(Request $request)
    {
        $search = $request->input('search', '');

        $disponiveis = Tecnico::where('disponibilidade', Disponibilidade::Disponivel)
            ->when($search, fn($q) => $q->where('nome', 'like', "%{$search}%"))
            ->get()
            ->map(fn($tecnico) => [
                'id' => $tecnico->id,
                'text' => $tecnico->nome,
            ]);

        $emAtendimento = Tecnico::where('disponibilidade', Disponibilidade::EmAtendimento)
            ->when($search, fn($q) => $q->where('nome', 'like', "%{$search}%"))
            ->get()
            ->map(fn($tecnico) => [
                'id' => $tecnico->id,
                'text' => $tecnico->nome,
            ]);

        return response()->json([
            [
                'text' => 'Técnicos Disponíveis',
                'children' => $disponiveis,
            ],
            [
                'text' => 'Técnicos em Atendimento',
                'children' => $emAtendimento,
            ],
        ]);
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
