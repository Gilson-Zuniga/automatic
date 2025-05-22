
document.getElementById('btn-agregar-tipo').addEventListener('click', function () {
    const container = document.getElementById('tipos-articulos-container');

    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2', 'tipo-articulo-item');

    div.innerHTML = `
        <input type="hidden" name="tipos_articulos_id[]" value="">
        <input type="text" name="tipos_articulos[]" class="form-control" placeholder="Nombre Tipo Artículo">
        <button type="button" class="btn btn-danger btn-eliminar-tipo">Eliminar</button>
    `;

    container.appendChild(div);
});

document.getElementById('tipos-articulos-container').addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-eliminar-tipo')) {
        e.target.closest('.tipo-articulo-item').remove();
    }
});

