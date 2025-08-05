@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Adicionar Cliente</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Aqui vamos listar os clientes vindos do Controller --}}
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cnpj }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop