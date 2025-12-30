@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <p>Welcome to this beautiful admin panel.</p>
        </div>

        <div class="card-body">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic dolores vero facere quo dolor consectetur
                ratione quas ad odio recusandae, quidem totam error optio, tempore, fugiat quos unde excepturi temporibus.
            </p>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        //console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
