document.addEventListener("DOMContentLoaded", () => {
    const itemsTable = document.querySelector("#items-table tbody");
    const addItemBtn = document.getElementById("add-item");
    const form = document.getElementById("factura-form");
    const itemsJsonInput = document.getElementById("items-json");

    const subtotalGeneralInput = document.getElementById("subtotal-general");
    const impuestoGeneralInput = document.getElementById("impuesto-general");
    const totalGeneralInput = document.getElementById("total-general");

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    // Toast de SweetAlert2
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

    function productosOptions() {
        return productos.map(p => `<option value="${p.id}" data-precio="${p.precio}">${p.nombre}</option>`).join('');
    }

    // Agregar ítem
    if (addItemBtn) {
        addItemBtn.addEventListener("click", () => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>
                    <select class="form-control producto" required>
                        <option value="" disabled selected>Seleccione</option>
                        ${productosOptions()}
                    </select>
                </td>
                <td><input type="number" class="form-control cantidad" value="1" min="1" required></td>
                <td><input type="number" class="form-control precio" step="0.01" min="0" required readonly></td>
                <td><input type="number" class="form-control subtotal" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
            `;
            itemsTable.appendChild(row);
        });
    }

    // Eliminar ítem
    document.addEventListener("click", e => {
        if (e.target.classList.contains("remove-item")) {
            e.target.closest("tr").remove();
            actualizarTotales();
        }
    });

    // Cambiar producto → actualizar precio
    document.addEventListener("change", e => {
        if (e.target.classList.contains("producto")) {
            const select = e.target;
            const selectedOption = select.options[select.selectedIndex];
            const precio = parseFloat(selectedOption.dataset.precio) || 0;

            const row = select.closest("tr");
            row.querySelector(".precio").value = precio.toFixed(2);

            actualizarFila(row);
            actualizarTotales();
        }
    });

    // Cambiar cantidad/precio → actualizar subtotales
    document.addEventListener("input", e => {
        if (e.target.classList.contains("cantidad") || e.target.classList.contains("precio")) {
            const row = e.target.closest("tr");
            actualizarFila(row);
            actualizarTotales();
        }
    });

    function actualizarFila(row) {
        const cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".precio").value) || 0;
        const subtotal = cantidad * precio;
        row.querySelector(".subtotal").value = subtotal.toFixed(2);
    }

    function actualizarTotales() {
        const filas = itemsTable.querySelectorAll("tr");
        let subtotalGeneral = 0;

        filas.forEach(row => {
            const subtotal = parseFloat(row.querySelector(".subtotal").value) || 0;
            subtotalGeneral += subtotal;
        });

        const impuestoGeneral = subtotalGeneral * 0.19; // 19%
        const totalGeneral = subtotalGeneral + impuestoGeneral;

        if (subtotalGeneralInput) subtotalGeneralInput.value = subtotalGeneral.toFixed(2);
        if (impuestoGeneralInput) impuestoGeneralInput.value = impuestoGeneral.toFixed(2);
        if (totalGeneralInput) totalGeneralInput.value = totalGeneral.toFixed(2);
    }

    // Serializar ítems antes de enviar
    if (form) {
        form.addEventListener("submit", (e) => {
            const items = [];
            const rows = itemsTable.querySelectorAll("tr");

            rows.forEach(row => {
                const productoSelect = row.querySelector(".producto");
                const producto_id = parseInt(productoSelect?.value);
                const cantidad = parseFloat(row.querySelector(".cantidad").value);
                const precio_unitario = parseFloat(row.querySelector(".precio").value);

                if (!isNaN(producto_id) && !isNaN(cantidad) && !isNaN(precio_unitario)) {
                    const impuesto = +(cantidad * precio_unitario * 0.19).toFixed(2);
                    items.push({
                        producto_id,
                        cantidad,
                        precio_unitario,
                        impuesto
                    });
                }
            });

            if (items.length === 0) {
                e.preventDefault();
                Swal.fire("Error", "Debe agregar al menos un ítem a la factura.", "warning");
                return;
            }

            itemsJsonInput.value = JSON.stringify(items);
        });
    }
});
