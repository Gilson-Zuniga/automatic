<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $producto->precio ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="categoria" class="form-label">Categoría</label>
    <select name="categoria" id="categoria" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        <option value="Tecnología" {{ old('categoria', $producto->categoria ?? '') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
        <option value="Papelería" {{ old('categoria', $producto->categoria ?? '') == 'Papelería' ? 'selected' : '' }}>Papelería</option>
        <option value="Muebles" {{ old('categoria', $producto->categoria ?? '') == 'Muebles' ? 'selected' : '' }}>Muebles</option>
        <option value="Aseo" {{ old('categoria', $producto->categoria ?? '') == 'Aseo' ? 'selected' : '' }}>Aseo</option>
    </select>
</div>

<div class="mb-3" id="tipo-articulo-container" style="display: none;">
    <label for="tipo_articulo" class="form-label">Tipo de Artículo</label>
    <select name="tipo_articulo" id="tipo_articulo" class="form-select" required
    data-seleccionado="{{ old('tipo_articulo', $producto->tipo_articulo ?? '') }}">
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

<div class="mb-3">
    <label for="foto" class="form-label">Imagen</label>
    <input type="file" name="foto" class="form-control" accept="image/*">
    @if (!empty($producto->foto))
        <img src="{{ asset('storage/' . $producto->foto) }}" alt="Imagen" width="100" class="mt-2">
    @endif
</div>
