document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert2 para mostrar mensajes flash
    const flashData = document.getElementById('flash-data');
    if (flashData) {
        const success = flashData.dataset.success;
        const error = flashData.dataset.error;

        if (success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: success,
                timer: 3000,
                showConfirmButton: false
            });
        }

        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                timer: 3000,
                showConfirmButton: false
            });
        }
    }

    // Confirmación para eliminación de factura
    document.querySelectorAll("form[id^='form-eliminar-']").forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Previene el envío inmediato

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará la factura permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });
});
