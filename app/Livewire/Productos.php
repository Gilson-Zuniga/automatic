<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Productos extends Component
{
    use WithPagination, WithFileUploads;

    public $nombre, $precio, $categoria_id, $tipo_articulo_id, $foto, $descripcion, $proveedor_nit, $producto_id;
    public $modoEdicion = false, $buscar = '', $perPage = 10;
    public $proveedores, $categorias, $tiposArticulos;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'categoria_id' => 'required|exists:categorias,id',
        'tipo_articulo_id' => 'required|exists:tipo_articulos,id',
        'descripcion' => 'nullable|string',
        'proveedor_nit' => 'required|exists:proveedores,nit',
        'foto' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->proveedores = Proveedor::all();
        $this->categorias = Categoria::all();
        $this->tiposArticulos = TipoArticulo::all();
    }

    public function render()
    {
        $productos = Producto::with(['proveedor', 'categoria', 'tipoArticulo'])
            ->where(function ($query) {
                if ($this->buscar) {
                    $query->where('id', $this->buscar)
                        ->orWhere('nombre', 'like', '%' . $this->buscar . '%');
                }
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.productos', compact('productos'));
    }

    public function guardar()
    {
        $this->validate();

        $datos = $this->only([
            'nombre', 'precio', 'categoria_id', 'tipo_articulo_id', 'descripcion', 'proveedor_nit'
        ]);

        if ($this->foto) {
            $datos['foto'] = $this->foto->store('productos', 'public');
        }

        Producto::create($datos);

        session()->flash('message', 'Producto creado correctamente.');
        $this->resetInputs();
    }

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->precio = $producto->precio;
        $this->categoria_id = $producto->categoria_id;
        $this->tipo_articulo_id = $producto->tipo_articulo_id;
        $this->descripcion = $producto->descripcion;
        $this->proveedor_nit = $producto->proveedor_nit;
        $this->modoEdicion = true;
    }

    public function actualizar()
    {
        $this->validate();

        $producto = Producto::findOrFail($this->producto_id);

        $datos = $this->only([
            'nombre', 'precio', 'categoria_id', 'tipo_articulo_id', 'descripcion', 'proveedor_nit'
        ]);

        if ($this->foto) {
            if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
                Storage::disk('public')->delete($producto->foto);
            }
            $datos['foto'] = $this->foto->store('productos', 'public');
        }

        $producto->update($datos);

        session()->flash('message', 'Producto actualizado correctamente.');
        $this->resetInputs();
    }

    public function eliminar($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
            Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        session()->flash('message', 'Producto eliminado correctamente.');
    }

    public function resetInputs()
    {
        $this->reset(['nombre', 'precio', 'categoria_id', 'tipo_articulo_id', 'foto', 'descripcion', 'proveedor_nit', 'producto_id', 'modoEdicion']);
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }
}
