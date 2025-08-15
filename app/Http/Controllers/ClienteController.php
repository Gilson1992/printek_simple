<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10); 

        return view('clientes.index', compact('clientes')); 
    }

    public function paginate(Request $request)
    {
        $q = $request->search;

        $result = Cliente::select('id', DB::raw("nome as text"))
                        ->where('nome', 'like', "%$q%")
                        ->orderBy('nome', 'asc')
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
