document.addEventListener("DOMContentLoaded", () => {
    const itemsTable = document.querySelector("#items-table tbody");
    const addItemBtn = document.getElementById("add-item");
    const form = document.getElementById("factura-form");
    const itemsJsonInput = document.getElementById("items-json");

    const subtotalGeneralInput = document.getElementById("subtotal-general");
    const impuestoGeneralInput = document.getElementById("impuesto-general");
    const totalGeneralInput = document.getElementById("total-general");

    const formatoMoneda = num => new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2
    }).format(num);

    function catalogoOptions() {
        return catalogo.map(item => `
            <option 
                value="${item.id}" 
                data-producto_id="${item.producto.id}"
                data-precio="${(item.valor-(item.valor*0.19))}" 
                data-descuento="${((item.descuento/100)*item.valor) ?? 0}"
                data-nombre="${item.producto.nombre ?? 'Producto'}"
            >
                ${item.producto.nombre ?? 'Producto'} - ${formatoMoneda(item.valor)}
            </option>
        `).join('');
    }

    addItemBtn.addEventListener("click", () => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>
                <select class="form-control producto" required>
                    <option value="" disabled selected>Seleccione</option>
                    ${catalogoOptions()}
                </select>
            </td>
            <td><input type="number" class="form-control cantidad" value="1" min="1" required></td>
            <td><input type="number" class="form-control precio" step="0.01" min="0" required readonly></td>
            <td><input type="number" class="form-control descuento" step="0.01" min="0" required readonly></td>
            <td><input type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
        `;
        itemsTable.appendChild(row);
    });

    document.addEventListener("click", e => {
        if (e.target.classList.contains("remove-item")) {
            e.target.closest("tr").remove();
            actualizarTotales();
        }
    });

    document.addEventListener("change", e => {
        if (e.target.classList.contains("producto")) {
            const select = e.target;
            const selectedOption = select.options[select.selectedIndex];

            // Validación: no permitir productos repetidos
            const selectedId = selectedOption.dataset.producto_id;
            let repetido = false;
            document.querySelectorAll(".producto").forEach(otherSelect => {
                if (otherSelect !== select && otherSelect.value === select.value) {
                    repetido = true;
                }
            });

            if (repetido) {
                Swal.fire("Error", "Este producto ya está agregado.", "error");
                select.value = "";
                return;
            }

            const precio = parseFloat(selectedOption.dataset.precio) || 0;
            const descuento = parseFloat(selectedOption.dataset.descuento) || 0;
            const row = select.closest("tr");

            row.querySelector(".precio").value = precio.toFixed(2);
            row.querySelector(".descuento").value = descuento.toFixed(2);

            actualizarFila(row);
            actualizarTotales();
        }
    });

    document.addEventListener("input", e => {
        if (e.target.classList.contains("cantidad")) {
            const row = e.target.closest("tr");
            actualizarFila(row);
            actualizarTotales();
        }
    });

    function actualizarFila(row) {
        const cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".precio").value) || 0;
        const descuento = parseFloat(row.querySelector(".descuento").value) || 0;

        const subtotal = (precio - descuento) * cantidad;
        row.querySelector(".subtotal").value = formatoMoneda(subtotal);
    }

    function actualizarTotales() {
        const filas = itemsTable.querySelectorAll("tr");
        let subtotalGeneral = 0;

        filas.forEach(row => {
            const subtotalText = row.querySelector(".subtotal").value.replace(/\D/g, '');
            const subtotal = parseFloat(subtotalText/100) || 0;
            subtotalGeneral += subtotal;
        });

        const impuestoGeneral = subtotalGeneral * 0.19;
        const totalGeneral = subtotalGeneral+impuestoGeneral ;

        if (subtotalGeneralInput) subtotalGeneralInput.value = formatoMoneda(subtotalGeneral);
        if (impuestoGeneralInput) impuestoGeneralInput.value = formatoMoneda(impuestoGeneral);
        if (totalGeneralInput) totalGeneralInput.value = formatoMoneda(totalGeneral);
    }

    form.addEventListener("submit", (e) => {
        const items = [];
        const rows = itemsTable.querySelectorAll("tr");

        rows.forEach(row => {
            const productoSelect = row.querySelector(".producto");
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const producto_id = parseInt(selectedOption.dataset.producto_id);
            const cantidad = parseFloat(row.querySelector(".cantidad").value);
            const precio_unitario = parseFloat(row.querySelector(".precio").value);
            const descuento = parseFloat(row.querySelector(".descuento").value);

            if (!isNaN(producto_id) && !isNaN(cantidad) && !isNaN(precio_unitario)) {
                const subtotal = (precio_unitario - descuento) * cantidad;
                const impuesto = +(subtotal * 0.19).toFixed(2);

                items.push({
                    producto_id,
                    cantidad,
                    precio_unitario,
                    descuento,
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
});
