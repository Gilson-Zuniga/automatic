<div class="mb-3">
    <label for="nit" class="form-label">NIT</label>
    <input type="text" name="nit" class="form-control" value="{{ old('nit', $proveedor->nit ?? '') }}" {{ isset($proveedor) ? 'readonly' : '' }}>
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $proveedor->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
</div>

<div class="mb-3">
    <label for="ciudad" class="form-label">Ciudad</label>
    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $proveedor->ciudad ?? '') }}">
</div>

<div class="mb-3">
    <label for="rut" class="form-label">RUT</label>
    <input type="text" name="rut" class="form-control" value="{{ old('rut', $proveedor->rut ?? '') }}">
</div>
