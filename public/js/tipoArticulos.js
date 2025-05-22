document.addEventListener("DOMContentLoaded", function () {
    const flashData = document.getElementById("flash-data");

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

    document.querySelectorAll(".eliminar-formulario").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción eliminará el tipo de artículo.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
