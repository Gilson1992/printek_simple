<?php

namespace App\Http\Controllers;

use App\Models\Peca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PecaController extends Controller
{
    public function index()
    {
        $pecas = Peca::latest()->paginate(10); 

        return view('pecas.index', compact('pecas')); 
    }

    public function paginate(Request $request)
    {
        $q = $request->search;

        $result = Peca::select('id', DB::raw("descricao as text"))
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
