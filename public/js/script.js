document.addEventListener('DOMContentLoaded', function () {
    // Mensajes Flash
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

    // Productos - Categorías y Tipo de Artículos
    const categoria = document.getElementById('categoria');
    const tipoArticulo = document.getElementById('tipo_articulo');
    const tipoArticuloContainer = document.getElementById('tipo-articulo-container');

    const opcionesPorCategoria = {
        'Tecnología': ['Celulares', 'Televisores', 'Smartwatch'],
        'Papelería': ['Cuadernos', 'Esferos', 'Carpetas'],
        'Muebles': ['Escritorios', 'Sillas', 'Estanterías'],
        'Aseo': ['Jabones', 'Desinfectantes', 'Escobas']
    };

    const tipoArticuloSeleccionado = tipoArticulo?.getAttribute('data-seleccionado');

    function actualizarOpciones(valorSeleccionado = null) {
        const seleccion = categoria.value;

        if (opcionesPorCategoria[seleccion]) {
            tipoArticuloContainer.style.display = 'block';
            tipoArticulo.innerHTML = '<option value="">Seleccione tipo</option>';

            opcionesPorCategoria[seleccion].forEach(opcion => {
                const opt = document.createElement('option');
                opt.value = opcion;
                opt.textContent = opcion;

                if (valorSeleccionado === opcion) {
                    opt.selected = true;
                }

                tipoArticulo.appendChild(opt);
            });
        } else {
            tipoArticuloContainer.style.display = 'none';
            tipoArticulo.innerHTML = '';
        }
    }

    // Ejecutar al cargar (modo editar)
    if (categoria && categoria.value) {
        actualizarOpciones(tipoArticuloSeleccionado);
    }

    // Al cambiar la categoría manualmente
    if (categoria) {
        categoria.addEventListener('change', function () {
            actualizarOpciones();
        });
    }
});

// Función para confirmar eliminación con SweetAlert
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
