@extends('adminlte::page')

@section('title', 'Ordens de Serviço')

@section('content_header')
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <h1 class="text-3xl font-bold">
            Ordens de Serviço
        </h1>
    </div>
@stop

@section('content')
    <div class="dark:bg-gray-900 bg-white px-4 pt-3 rounded-md shadow-lg">
        <livewire:powergrid.ordem-servico-table/>
    </div>
@stop

@section('footer')
    <livewire:components.copyright/>
@stop
