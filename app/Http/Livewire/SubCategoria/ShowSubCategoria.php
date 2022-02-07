<?php

namespace App\Http\Livewire\SubCategoria;

use App\Models\SubCategoria;

use Livewire\Component;

use Livewire\WithPagination;

class ShowSubCategoria extends Component
{

    use WithPagination;

    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $estado;
    public $open = false;

    public $nombre;
    public $descripcion;
    public $image;

    protected $listeners = ['render' => 'render', 'eliminar'];

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $subcategorias = SubCategoria::where('nombre','like','%'.$this->search.'%')
                                ->orWhere('descripcion','like','%'.$this->search.'%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate(10);

        return view('livewire.sub-categoria.show-sub-categoria', compact('subcategorias'))
        ->layout('layouts.paneldos');
    }

    public function order($orden){

        if ($this->sort = $orden) {
            
            if ($this->direction == 'desc') {
                $this->direction= 'asc';
            }else{
                $this->direction= 'desc';
            }

        }
        
    }

    public function activar($id)
    {
        // if (!$request->ajax()) return redirect('/');
        $subcategoria = SubCategoria::findOrFail($id);
        $subcategoria->estado = 0;
        $subcategoria->save(); 
    }

    public function desactivar($id)
    {
        // if (!$request->ajax()) return redirect('/');
        $subcategoria = SubCategoria::findOrFail($id);
        $subcategoria->estado = 1;
        $subcategoria->save();
    }

    public function eliminar(SubCategoria $subcategoria)
    {
        $subcategoria->delete();
    }
}
