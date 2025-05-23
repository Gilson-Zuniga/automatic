document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-data');
    const successMessage = flash?.dataset.success;
    const errorMessage = flash?.dataset.error;

    // Mostrar mensajes de éxito/error si existen
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

    // 💡 Diccionario de tipos de artículo agrupados por categoria_id (inyectado por Blade)
    const tiposPorCategoria = window.tiposPorCategoria || {};

    // 🔁 Función para actualizar dinámicamente el select de tipo_articulo
    function actualizarTipos(categoriaSelect, tipoSelect, seleccionado = null) {
        const categoriaId = categoriaSelect.value;
        const tipos = tiposPorCategoria[categoriaId] || [];

        tipoSelect.innerHTML = ''; // limpiar opciones anteriores

        tipos.forEach(tipo => {
            const option = document.createElement('option');
            option.value = tipo.id;
            option.textContent = tipo.nombre;
            if (seleccionado && seleccionado == tipo.id) {
                option.selected = true;
            }
            tipoSelect.appendChild(option);
        });

        // Mostrar o esconder el contenedor según si hay opciones
        const container = tipoSelect.closest('#tipo-articulo-container');
        if (container) {
            container.style.display = tipos.length > 0 ? 'block' : 'none';
        }
    }

    // 🔗 Asociar eventos a todos los formularios (crear y editar)
    document.querySelectorAll('form').forEach(form => {
        const categoria = form.querySelector('#categoria_id');
        const tipo = form.querySelector('#tipo_articulo_id');

        if (!categoria || !tipo) return;

        const seleccionado = tipo.getAttribute('data-seleccionado');

        // Evento: cuando se cambia la categoría
        categoria.addEventListener('change', () => {
            actualizarTipos(categoria, tipo);
        });

        // Al cargar el formulario (para precargar si ya hay selección previa)
        actualizarTipos(categoria, tipo, seleccionado);
    });
});

// 🔥 Confirmar eliminación con SweetAlert
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
