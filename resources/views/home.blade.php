
@extends('adminlte::page')

@section('title', 'Automatic Control')

@section('content_header')
    <h1>Tablero de trabajo</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
        <div class="card-header">
                <h2 class="card-title">Informes en vivo</h2>
            </div>
            <div class="card-body"><p>Lleva el control en tiempo de real de los cambios en tu inventario </p></div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop