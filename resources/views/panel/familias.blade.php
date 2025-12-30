@extends('adminlte::page')

@section('content_header')
    <h1>Gestionar Familias</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestionar Familias</h3>
        </div>
        <div class="card-body text-right">
            <a class="btn btn-app bg-success">
                <span class="badge bg-danger">3</span>
                <i class="fas fa-user-plus"></i> Nuevo
            </a>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($familias as $familia)
                        <tr>
                            <td>{{ $familia->id }}</td>
                            <td>{{ $familia->name }}</td>
                            <td>{{ $familia->description }}</td>
                            <td>
                                <a href="#" class="btn btn-primary">Editar</a>
                                <button class="btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop
