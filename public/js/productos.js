document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-data');
    const successMessage = flash?.dataset.success;
    const errorMessage = flash?.dataset.error;

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: successMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    const opcionesPorCategoria = {
        'Tecnología': ['Celulares', 'Televisores', 'Smartwatch'],
        'Papelería': ['Cuadernos', 'Esferos', 'Carpetas'],
        'Muebles': ['Escritorios', 'Sillas', 'Estanterías'],
        'Aseo': ['Jabones', 'Desinfectantes', 'Escobas']
    };

    function actualizarOpciones(categoriaSelect, tipoArticuloSelect, seleccionado = null) {
        const categoria = categoriaSelect.value;
        const opciones = opcionesPorCategoria[categoria] || [];

        // Limpiar opciones anteriores
        tipoArticuloSelect.innerHTML = '';

        opciones.forEach(opcion => {
            const option = document.createElement('option');
            option.value = opcion;
            option.text = opcion;
            if (opcion === seleccionado) {
                option.selected = true;
            }
            tipoArticuloSelect.appendChild(option);
        });

        // Mostrar si hay opciones
        const container = tipoArticuloSelect.closest('#tipo-articulo-container');
        if (container) {
            container.style.display = opciones.length > 0 ? 'block' : 'none';
        }
    }

    // Asignar eventos a cada formulario (crear y editar)
    document.querySelectorAll('form').forEach(form => {
        const categoria = form.querySelector('#categoria');
        const tipoArticulo = form.querySelector('#tipo_articulo');

        if (!categoria || !tipoArticulo) return;

        const seleccionado = tipoArticulo.getAttribute('data-seleccionado');

        // Evento para actualizar dinámicamente
        categoria.addEventListener('change', () => {
            actualizarOpciones(categoria, tipoArticulo);
        });

        // Ejecutar al abrir modal (por si está prellenado)
        actualizarOpciones(categoria, tipoArticulo, seleccionado);
    });
});

// Confirmar eliminación con SweetAlert
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    });
}
