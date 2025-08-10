@extends('adminlte::page')

@section('title', 'Endividamento')

@section('content_header')
    <div style="display:flex;align-items:center;justify-content:space-between;">
        <h1 class="m-0 text-dark">Equipamentos</h1>
        <i class="fas fa-hand-holding-usd" style="color:#f57600;margin-right:83%;"></i>
    </div>
@stop

@section('content')
    <div class="bg-white px-4 pt-3 rounded-md shadow-lg">
        <livewire:powergrid.equipamentos-datatables/>
    </div>
@stop

