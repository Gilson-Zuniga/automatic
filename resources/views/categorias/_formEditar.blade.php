@php
    $categoria = $categoria ?? null;
@endphp

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre Categoría</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria?->nombre) }}" class="form-control">
</div>

<div id="tipos-articulos-container">
    @php
        $tipos_nombres = old('tipos_articulos', $categoria?->tipoArticulos->pluck('nombre')->toArray() ?? []);
        $tipos_ids = old('tipos_articulos_id', $categoria?->tipoArticulos->pluck('id')->toArray() ?? []);
    @endphp

    @foreach($tipos_nombres as $index => $nombre)
        <div class="input-group mb-2 tipo-articulo-item d-none">
            <input type="hidden" name="tipos_articulos_id[]" value="{{ $tipos_ids[$index] ?? '' }}">
            <input type="text" name="tipos_articulos[]" value="{{ $nombre }}" class="form-control" placeholder="Nombre Tipo Artículo">
            <button type="button" class="btn btn-danger btn-eliminar-tipo">Eliminar</button>
        </div>
    @endforeach
</div>

