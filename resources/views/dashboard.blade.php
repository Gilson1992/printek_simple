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
    <div class="float-right d-none d-sm-block">
        <b>Versão</b> 1.0
    </div>
    <strong>Copyright &copy; 2024-{{ date('Y') }} <a href="#">Evoluta Printer</a>.</strong> Todos os direitos reservados.
@stop

{{-- Adicionar arquivos CSS extras --}}
@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

{{-- Adicionar arquivos JS extras --}}
@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop