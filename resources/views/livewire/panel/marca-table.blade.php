<div>
    @section('content_header')
        <h1>Listado de Marcas</h1>
    @stop

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Gestionar Marcas</h1>
        </div>

        <div class="card-tools p-3">
            <!-- Modal Edicion y Creacion-->
            <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog shadow-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">{{ $selected_id ? 'Editar Marca' : 'Nueva Marca' }}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    wire:model="name">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" wire:model="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror"
                                        wire:model="logo" id="upload{{ $selected_id }}">
                                    <label class="custom-file-label" for="upload{{ $selected_id }}">
                                        {{ $logo ? $logo->getClientOriginalName() : 'Seleccionar imagen...' }}
                                    </label>
                                    @error('logo')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div wire:loading wire:target="logo" class="text-primary mt-2">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando vista previa...
                                </div>
                                <div class="mt-3 text-center">
                                    @if ($logo)
                                        <p>Vista previa:</p>
                                        <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail"
                                            style="height: 120px;">
                                    @elseif($old_logo)
                                        <p>Imagen actual:</p>
                                        <img src="{{ asset('storage/' . $old_logo) }}" class="img-thumbnail"
                                            style="height: 120px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" wire:click="store" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Edicion y Creacion-->
        </div>

        <div class="card-body p-3">
            {{-- Table section --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        placeholder="Buscar por nombre o descripción..." wire:model.live="search">
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <button wire:click="create" class="btn btn-primary">
                                    <i class="fas fa-star"></i> Nueva Marca
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($marcas->count() > 0)
                            <div class="table-responsive shadow rounded">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>Logo</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th width="150px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($marcas as $marca)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $marca->logo) }}" alt="Logo"
                                                        class="rounded-circle img-thumbnail"
                                                        style="width: 60px;height: 60px;">
                                                </td>
                                                <td>{{ $marca->name }}</td>
                                                <td>{{ $marca->description }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $marca->id }})"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button
                                                        onclick="confirmDelete({{ $marca->id }}, '{{ $marca->name }}')"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                {{ $marcas->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-gray mb-3"></i>
                                <p class="text-muted h5">
                                    @if ($search != '')
                                        No se encontraron marcas que coincidan con "{{ $search }}"
                                    @else
                                        No hay marcas registradas en el sistema.
                                    @endif
                                </p>
                                @if ($search != '')
                                    <button class="btn btn-link" wire:click="$set('search', '')">Limpiar
                                        búsqueda</button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            {{-- End Table section --}}

        </div>
    </div>
    <script>
        window.addEventListener('close-edit-modal', event => {
            $('#modalEdit').modal('hide');
        });
        window.addEventListener('open-edit-modal', event => {
            $('#modalEdit').modal('show');
        });

        window.addEventListener('open-modal-delete', event => {
            $('#modalDelete').modal('show');
        });

        window.addEventListener('close-modal-delete', event => {
            $('#modalDelete').modal('hide');
        });

        window.addEventListener('alert-success', event => {
            alert(event.detail); // Un alert simple para confirmar que funcionó
        });

        function confirmDelete(id, name) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar la marca "${name}". ¡Esta acción no se puede deshacer!`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Rojo para confirmar
                cancelButtonColor: '#3085d6', // Azul para cancelar
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    @this.call('delete', id);
                }
            })
        }
    </script>
</div>
