@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')

    @livewire('wire-elements-modal')
    @wireUiScripts
    @vite(['resources/js/app.js'])
    {{-- @livewireStyles --}}

    <style>
        .btn-orange {
                color: #fff;
                background-color: #fc7d14 !important;
                border-color: #fc7d14 !important;
                box-shadow: none;
                font-weight: bolder;
            }

            .btn:hover, .btn:active {
                border-color: #0000 !important;
                color: #212529 !important;
            }

            .btn:focus {
                border-color: #0000 !important;
            }

            .btn:not(:disabled):not(.disabled):active, .btn-orange.disabled, .btn-orange:disabled {
                border-color: #0000 !important;
            }
    </style>
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

        @include('sweetalert2::index')
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
