<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;

class Tienda extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'cat')]
    public $categoria_id = '';

    #[Url(as: 'marca')]
    public $marca_id = '';

    // Nueva variable de Livewire para el menú de celular (Sin Alpine)
    public $mostrarFiltrosMobile = false;

    public function updatingSearch() { $this->resetPage(); }

    public function seleccionarCategoria($id) 
    {
        $this->categoria_id = $id;
        $this->resetPage();
    }

    public function seleccionarMarca($id) 
    {
        $this->marca_id = $id;
        $this->resetPage();
    }

    public function limpiarFiltros() 
    {
        $this->reset(['search', 'categoria_id', 'marca_id']);
        $this->resetPage();
    }

    public function toggleFiltros()
    {
        $this->mostrarFiltrosMobile = !$this->mostrarFiltrosMobile;
    }

    public function render()
    {
        $query = Producto::with(['categoria', 'marca']);

        // 1. Buscador
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        $idReal = null;
        $padreActivo = null;
        $hijosActivos = collect();

        // 2. Filtro de Categoría Aisaldo
        if (!empty($this->categoria_id)) {
            
            // Traductor para cuando entras desde el Navbar superior
            if (!is_numeric($this->categoria_id)) {
                $slugBuscado = Str::slug($this->categoria_id);
                $catEncontrada = Categoria::all()->first(fn($c) => Str::slug($c->nombre) === $slugBuscado);
                $idReal = $catEncontrada ? $catEncontrada->id : null;
            } else {
                $idReal = $this->categoria_id;
            }

            if ($idReal) {
                $categoriaActual = Categoria::find($idReal);

                if ($categoriaActual) {
                    if (is_null($categoriaActual->parent_id)) {
                        // Es un PADRE (Ej: Agro-forestal)
                        $padreActivo = $categoriaActual;
                        $hijosActivos = Categoria::where('parent_id', $padreActivo->id)->get();
                        
                        $hijosIds = $hijosActivos->pluck('id')->toArray();
                        $hijosIds[] = $idReal; 
                        $query->whereIn('categoria_id', $hijosIds);
                    } else {
                        // Es un HIJO (Ej: Agricultura)
                        $padreActivo = Categoria::find($categoriaActual->parent_id);
                        $hijosActivos = Categoria::where('parent_id', $padreActivo->id)->get();
                        
                        $query->where('categoria_id', $idReal);
                    }
                }
            }
        }

        // 3. Filtro de Marca
        if (!empty($this->marca_id)) {
            $query->where('marca_id', $this->marca_id);
        }

        return view('livewire.tienda', [
            'productos' => $query->latest()->paginate(12),
            'categoriasPadre' => Categoria::whereNull('parent_id')->get(),
            'marcasDb' => Marca::all(),
            'padreActivo' => $padreActivo,
            'hijosActivos' => $hijosActivos,
            'idReal' => $idReal
        ]);
    }
}