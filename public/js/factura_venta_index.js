document.addEventListener("DOMContentLoaded", () => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    // SweetAlert2 Toast
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    // Mostrar mensajes flash
    const flashData = document.getElementById("flash-data");
    if (flashData) {
        const success = flashData.dataset.success;
        const error = flashData.dataset.error;
        if (success) {
            Toast.fire({ icon: "success", title: success });
        }
        if (error) {
            Toast.fire({ icon: "error", title: error });
        }
    }

    // Confirmación para eliminar factura
    document.querySelectorAll("form[id^='form-eliminar-']").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
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
