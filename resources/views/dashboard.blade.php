@extends('adminlte::page')

{{-- Título da página --}}
@section('title', 'Painel')

{{-- Título do cabeçalho da página --}}
@section('content_header')
    <h1>Painel de Controle</h1>
@stop

{{-- Conteúdo principal da página --}}
@section('content')
    <p>Bem-vindo ao seu painel administrativo!</p>
@stop

{{-- Rodapé da página --}}
@section('footer')
    <livewire:components.copyright/>
@stop

{{-- Adicionar arquivos CSS extras --}}
@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

{{-- Adicionar arquivos JS extras --}}
@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop