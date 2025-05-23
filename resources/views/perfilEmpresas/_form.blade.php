<div class="mb-3">
    <label for="nit" class="form-label">NIT</label>
    <input type="text" name="nit" class="form-control" value="{{ old('nit', $empresa->nit ?? '') }}" {{ isset($empresa) ? 'readonly' : '' }} required>
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $empresa->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $empresa->direccion ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $empresa->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $empresa->telefono ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="ciudad" class="form-label">Ciudad</label>
    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $empresa->ciudad ?? '') }}" required>
</div>
