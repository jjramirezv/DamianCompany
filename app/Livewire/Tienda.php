<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;

class Tienda extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'cat')]
    public $categoria = '';

    #[Url(as: 'marca')]
    public $marca = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoria() { $this->resetPage(); }
    public function updatingMarca() { $this->resetPage(); }

    public function limpiarFiltros()
    {
        $this->reset(['search', 'categoria', 'marca']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Producto::with(['categoria', 'marca']);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        $activeParentId = null;

        if (!empty($this->categoria)) {
            if (is_numeric($this->categoria)) {
                $catSeleccionada = Categoria::find($this->categoria);
            } else {
                $nombreLimpio = str_replace('-', ' ', $this->categoria);
                
                // CORRECCIÓN AQUÍ: Busca con el guion original O con el espacio
                $catSeleccionada = Categoria::where('nombre', 'like', '%' . $this->categoria . '%')
                                            ->orWhere('nombre', 'like', '%' . $nombreLimpio . '%')
                                            ->first();
            }

            if ($catSeleccionada) {
                $activeParentId = $catSeleccionada->parent_id ?? $catSeleccionada->id;

                if (is_null($catSeleccionada->parent_id)) {
                    $ids = Categoria::where('parent_id', $catSeleccionada->id)->pluck('id')->push($catSeleccionada->id);
                    $query->whereIn('categoria_id', $ids);
                } else {
                    $query->where('categoria_id', $catSeleccionada->id);
                }
            }
        }

        if (!empty($this->marca)) {
            $query->where('marca_id', $this->marca);
        }

        $productos = $query->latest()->paginate(12);
        $categoriasDb = Categoria::all();
        $marcasDb = Marca::all();

        return view('livewire.tienda', [
            'productos' => $productos,
            'categoriasDb' => $categoriasDb,
            'marcasDb' => $marcasDb,
            'activeParentId' => $activeParentId
        ]);
    }
}