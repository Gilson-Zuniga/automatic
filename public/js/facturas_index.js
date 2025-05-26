// public/js/factura_index.js
document.addEventListener("DOMContentLoaded", () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

    document.querySelectorAll(".btn-eliminar").forEach(btn => {
        btn.addEventListener("click", function () {
            const facturaId = this.dataset.id;
            const facturaNombre = this.dataset.nombre;

            Swal.fire({
                title: `¿Eliminar la factura #${facturaNombre}?`,
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/facturas_proveedores/${facturaId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Accept": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Factura eliminada",
                                text: `La factura #${facturaNombre} fue eliminada.`,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            const row = document.querySelector(`#factura-row-${facturaId}`);
                            if (row) row.remove();
                        } else {
                            Swal.fire("Error", "No se pudo eliminar la factura.", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire("Error", "Ocurrió un error al eliminar.", "error");
                    });
                }
            });
        });
    });
});
