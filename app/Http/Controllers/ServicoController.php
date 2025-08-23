<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::latest()->paginate(10); 

        return view('servicos.index', compact('servicos')); 
    }

    public function paginate(Request $request)
    {
        $q = $request->search;

        $result = Servico::select('id', DB::raw("descricao as text"))
                        ->where('descricao', 'like', "%$q%")
                        ->orderBy('descricao', 'asc')
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
