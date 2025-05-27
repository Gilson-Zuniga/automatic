<div class="mb-3">
    <label for="valor" class="form-label">Valor</label>
    <input type="number" step="0.01" name="valor" class="form-control" value="{{ old('valor', $catalogo->valor ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="descuento" class="form-label">Descuento</label>
    <input type="number" step="0.01" name="descuento" class="form-control" value="{{ old('descuento', $catalogo->descuento ?? 0) }}">
</div>
