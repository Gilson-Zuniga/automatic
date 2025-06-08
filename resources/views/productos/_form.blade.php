<form method="POST" enctype="multipart/form-data">
<!-- El atributo enctype es esencial para subir archivos -->
<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio Neto</label>
    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $producto->precio ?? '') }}" placeholder="Valor sin Impuestos" required>
</div>
{{-- Categoría --}}
<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" id="categoria_id" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

{{-- Tipo de artículo --}}
<div class="mb-3" id="tipo-articulo-container" style="display: none;">
    <label for="tipo_articulo_id" class="form-label">Tipo de Artículo</label>
    <select name="tipo_articulo_id" id="tipo_articulo_id" class="form-select" data-seleccionado="{{ old('tipo_articulo_id', $producto->tipo_articulo_id ?? '') }}">
        <!-- Se llena dinámicamente por JS -->
    </select>
</div>


<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="proveedor_nit" class="form-label">Proveedor</label>
    <select name="proveedor_nit" class="form-select" required>
        <option value="">Seleccione un proveedor</option>
        @foreach($proveedores as $proveedor)
            <option value="{{ $proveedor->nit }}"
                {{ (old('proveedor_nit', $producto->proveedor_nit ?? '') == $proveedor->nit) ? 'selected' : '' }}>
                {{ $proveedor->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Subir imagen o ingresar URL</label>
    <div class="row">
        <div class="col-md-6">
            <input type="file" class="form-control" name="foto" accept="image/*">
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">URL</span>
                <input type="text" class="form-control" name="foto_url" 
                       placeholder="https://ejemplo.com/imagen.jpg"
                       value="{{ old('foto_url', $producto->foto ?? '') }}">
            </div>
        </div>
    </div>
</div>

