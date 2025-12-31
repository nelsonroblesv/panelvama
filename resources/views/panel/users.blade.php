@extends('adminlte::page')

@section('content_header')
    <h1>Gestionar Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestionar Usuarios</h3>
        </div>
        <div class="card-body text-right">
            <a class="btn btn-app bg-success">
                <span class="badge bg-danger">3</span>
                <i class="fas fa-user-plus"></i> Nuevo
            </a>
        </div>
        @php
            $heads = ['ID', 'Nombre', 'Puesto', 'Telefono', 'Acciones'];

            $btnEdit = '<button class="btn btn-xs text-primary mx-1" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
            $btnDelete = '<button class="btn btn-xs text-danger mx-1 rounded" title="Borrar">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
            $btnDetails = '<button class="btn btn-xs text-teal mx-1" title="Detalles">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

            $config = [
                'data' => [
                    [
                        'https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740&q=80',
                        'Nelson Jose Robles Vazquez',
                        'Developer',
                        '+02 (123) 123456789',
                        '<nobr>' . $btnDetails . $btnEdit . $btnDelete . '</nobr>',
                    ],
                    [
                        'https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740&q=80',
                        'Sophia Clemens',
                        'Ventas',
                        '+99 (987) 987654321',
                        '<nobr>' . $btnDetails . $btnEdit . $btnDelete . '</nobr>',
                    ],
                    [
                        'https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740&q=80',
                        'Peter Sousa',
                        'Gerente',
                        '+69 (555) 12367345243',
                        '<nobr>' . $btnDetails . $btnEdit . $btnDelete . '</nobr>',
                    ],
                ],
            ];
        @endphp

        <div class="card-body p-3">
            <x-adminlte-datatable id="table4" :heads="$heads" :config="$config" head-theme="dark" bordered hoverable
                with-buttons>
                @foreach ($config['data'] as $row)
                    <tr>
                        <td><img src="{{ $row[0] }}" width="50" class="rounded-circle"></td>
                        <td>{{ $row[1] }}</td>
                        <td>{{ $row[2] }}</td>
                        <td>{{ $row[3] }}</td>
                        <td>{!! $row[4] !!}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
