<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del Tipo de Artículo</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $tipoArticulo->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" id="categoria_id" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ (old('categoria_id', $tipoArticulo->categoria_id ?? '') == $categoria->id) ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>
