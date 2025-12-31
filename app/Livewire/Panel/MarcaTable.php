<?php

namespace App\Livewire\Panel;

use Livewire\Component;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

class MarcaTable extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use WithFileUploads;

    public $name, $description, $selected_id, $logo, $old_logo;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('marcas', 'name')->ignore($this->selected_id),
            ],
            'description' => 'nullable|max:255',
            'logo' => 'nullable|image|max:1024'
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
        $this->description = '';
        $this->selected_id = null;
        $this->logo = null;
        $this->old_logo = null;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        if ($this->logo) {
            // Eliminar logo anterior si existe
            if ($this->selected_id) {
                $marca = Marca::find($this->selected_id);
                if ($marca->logo) Storage::disk('public')->delete($marca->logo);
            }

            // Guardar nuevo logo
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        Marca::updateOrCreate(['id' => $this->selected_id], $data);

        $this->dispatch('close-edit-modal');
        $this->resetInputFields();

        $this->swalFire([
            'title' => 'Marca guardada!',
            'text' => 'La marca se ha guardado correctamente',
            'type' => 'success',
            'confirmButtonText' => 'OK'
        ]);
    }

    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $marca->name;
        $this->description = $marca->description;
        $this->old_logo = $marca->logo; // Cargamos la ruta de la imagen actual
        $this->logo = null; // Reseteamos el input de archivo
        $this->dispatch('open-edit-modal');
    }

    public function delete($id)
    {
        $marca = Marca::find($id);
        if ($marca) {
            $marca->delete();
        }
        $this->resetInputFields();
        $this->resetValidation();

        $this->swalFire([
            'title' => 'Marca eliminada!',
            'text' => 'La marca se ha eliminado correctamente',
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
        $query = Marca::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc');

        return view('livewire.panel.marca-table', [
            'marcas' => $query->paginate(5)
        ]);
    }
}
