@extends('adminlte::page')
@include('sweetalert2::index')

@section('content')
    {{ $slot }}
@stop
@push('css')
    <style type="text/css">
        body {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 300;
            font-size: 0.9em !important;
            /* Peso normal */
        }

        h3,
        .card-title {
            font-weight: 300;
            /* Para que los títulos resalten */
        }
    </style>
@endpush

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        //console.log("Hi, I'm using the Laravel-AdminLTE package!"); <
    </script>
@stop
