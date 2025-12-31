<?php

namespace App\Livewire\Panel;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

class UserTable extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use WithFileUploads;

    public $name, $email, $password, $phone, $role, $selected_id, $photo, $old_photo;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('users', 'name')->ignore($this->selected_id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->selected_id),
            ],
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'photo' => 'nullable|image|max:1024'
        ];
    }

    public function create()
    {
        $this->resetInputFields();
        $this->resetValidation();
        $this->dispatch('open-edit-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->role = '';
        $this->selected_id = null;
        $this->photo = null;
        $this->old_photo = null;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'role' => $this->role,
        ];

        if ($this->photo) {
            // Eliminar logo anterior si existe
            if ($this->selected_id) {
                $user = User::find($this->selected_id);
                if ($user->photo) Storage::disk('public')->delete($user->photo);
            }

            // Guardar nueva Foto
            $data['photo'] = $this->photo->store('users', 'public');
        }

        User::updateOrCreate(['id' => $this->selected_id], $data);

        $this->dispatch('close-edit-modal');
        $this->resetInputFields();

        $this->swalFire([
            'title' => 'Usuario creado!',
            'text' => 'El usuario se ha guardado correctamente',
            'type' => 'success',
            'confirmButtonText' => 'OK'
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->old_photo = $user->photo; // Cargamos la ruta de la imagen actual
        $this->photo = null; // Reseteamos el input de archivo
        $this->dispatch('open-edit-modal');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        $this->resetInputFields();
        $this->resetValidation();

        $this->swalFire([
            'title' => 'Usuario eliminado!',
            'text' => 'El usuario se ha eliminado correctamente',
            'type' => 'error',
            'confirmButtonText' => 'OK'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc');

        return view('livewire.panel.user-table', [
            'users' => $query->paginate(5)
        ]);
    }
}
