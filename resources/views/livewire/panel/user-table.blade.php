<div>
    @section('content_header')
        <h1>Listado de Usuarios</h1>
    @stop

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Gestionar Usuarios</h1>
        </div>

        <div class="card-tools p-3">
            <!-- Modal Edicion y Creacion-->
            <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog shadow-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">{{ $selected_id ? 'Editar Usuario' : 'Nuevo Usuario' }}</h5>
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
                                <label>Correo</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    wire:model="email">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    wire:model="phone">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Puesto</label>
                                <select name="role" id=""
                                    class="form-control @error('role') is-invalid @enderror" wire:model="role">
                                    <option value="">Seleccione un puesto</option>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    wire:model="password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="photo">Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror"
                                        wire:model="photo" id="upload{{ $selected_id }}">
                                    <label class="custom-file-label" for="upload{{ $selected_id }}">
                                        {{ $photo ? $photo->getClientOriginalName() : 'Seleccionar imagen...' }}
                                    </label>
                                    @error('photo')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div wire:loading wire:target="photo" class="text-primary mt-2">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando vista previa...
                                </div>
                                <div class="mt-3 text-center">
                                    @if ($photo)
                                        <p>Vista previa:</p>
                                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail"
                                            style="height: 120px;">
                                    @elseif($old_photo)
                                        <p>Imagen actual:</p>
                                        <img src="{{ asset('storage/' . $old_photo) }}" class="img-thumbnail"
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


        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Buscar por nombre..."
                                    wire:model.live="search">
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <button wire:click="create" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Nuevo Usuario
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-3">
                    @if ($users->count() > 0)

                        <table class="table table-hover text-nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th style="width: 100px;">Foto</th>
                                    <th>Nombre</th>
                                    <th>Puesto</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="w-100 h-100">
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Logo"
                                                    class="img-fluid w-100 h-100 object-fit-cover rounded-pill">
                                            </div>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td style="width: 250px;">
                                            <button wire:click="edit({{ $user->id }})"
                                                class="btn btn-sm btn-info m-2">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            <button
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                class="btn btn-sm btn-danger m-2">
                                                <i class="fas fa-trash"></i> Borrar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-gray mb-3"></i>
                            <p class="text-muted h5">
                                @if ($search != '')
                                    No se encontraron usuarios que coincidan con "{{ $search }}"
                                @else
                                    No hay usuarios registrados en el sistema.
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
                text: `Vas a eliminar el usuario "${name}". ¡Esta acción no se puede deshacer!`,
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

</div>
