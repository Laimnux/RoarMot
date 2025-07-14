<?= $this->extend('Layouts/PanelLayout') ?>

<?= $this->section('content') ?>

    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-6">Editar o eliminar productos</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 sm:px-6 sm:py-3 mb-4 border border-green-400 rounded text-sm sm:text-base"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 sm:px-6 sm:py-3 mb-4 border border-red-400 rounded text-sm sm:text-base"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white p-4 sm:p-6 md:p-8 rounded-lg shadow">
        <div class="min-w-[900px]">
            <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-pink-600 text-white">
                    <tr>
                        <th class="p-2 sm:p-3 text-sm sm:text-base">Nombre</th>
                        <th class="p-2 sm:p-3 text-sm sm:text-base">Marca</th>
                        <th class="p-2 sm:p-3 text-sm sm:text-base">Cantidad</th>
                        <th class="p-2 sm:p-3 text-sm sm:text-base">Precio</th>
                        <th class="p-2 sm:p-3 text-sm sm:text-base">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" data-product-id="<?= esc($producto['ID']) ?>">
                            <td class="p-2 sm:p-3">
                                <input name="nombre" value="<?= esc($producto['NOMBRE']) ?>" class="input-editable border border-gray-300 px-2 py-1 sm:px-3 sm:py-2 rounded w-full text-gray-800 bg-gray-100 cursor-not-allowed text-sm sm:text-base" readonly>
                            </td>
                            <td class="p-2 sm:p-3">
                                <input name="marca" value="<?= esc($producto['MARCA']) ?>" class="input-editable border border-gray-300 px-2 py-1 sm:px-3 sm:py-2 rounded w-full text-gray-800 bg-gray-100 cursor-not-allowed text-sm sm:text-base" readonly>
                            </td>
                            <td class="p-2 sm:p-3">
                                <input name="cantidad" type="number" value="<?= esc($producto['CANTIDAD']) ?>" class="input-editable border border-gray-300 px-2 py-1 sm:px-3 sm:py-2 rounded w-full text-gray-800 bg-gray-100 cursor-not-allowed text-sm sm:text-base" readonly>
                            </td>
                            <td class="p-2 sm:p-3">
                                <input name="precio_venta" type="number" step="0.01" value="<?= esc($producto['PRECIO']) ?>" class="input-editable border border-gray-300 px-2 py-1 sm:px-3 sm:py-2 rounded w-full text-gray-800 bg-gray-100 cursor-not-allowed text-sm sm:text-base" readonly>
                            </td>
                            <td class="p-2 sm:p-3 flex flex-col sm:flex-row gap-2">
                                <button type="button" class="btn-editar bg-yellow-400 hover:bg-yellow-500 px-3 py-1 sm:px-4 sm:py-2 rounded text-white text-xs sm:text-sm whitespace-nowrap">Editar</button>
                                
                                <button type="button" class="btn-guardar hidden bg-green-600 hover:bg-green-700 px-3 py-1 sm:px-4 sm:py-2 rounded text-white text-xs sm:text-sm whitespace-nowrap">Guardar</button>
                                
                                <button type="button" class="btn-cancelar hidden bg-gray-500 hover:bg-gray-600 px-3 py-1 sm:px-4 sm:py-2 rounded text-white text-xs sm:text-sm whitespace-nowrap">Cancelar</button>
                                
                                <form action="<?= base_url('panel/deleteProductProceso') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                    <input type="hidden" name="id" value="<?= esc($producto['ID']) ?>">
                                    <button type="submit" name="eliminar" class="bg-red-600 hover:bg-red-700 px-3 py-1 sm:px-4 sm:py-2 rounded text-white text-xs sm:text-sm w-full whitespace-nowrap">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500 text-base sm:text-lg">No hay productos para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Descargar productos agregados a Excel</h2>
        <a href="<?=base_url('panel/descargarExcel');?>" 
            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md inline-flex items-center transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Descargar Excel
        </a>
    </div>

    <script>
        // Función para mostrar mensajes (reemplazo de alert)
        function mostrarMensaje(mensaje, tipo) {
            const existingMessage = document.querySelector('.temp-message-container');
            if (existingMessage) {
                existingMessage.remove(); // Elimina cualquier mensaje anterior
            }

            const container = document.createElement('div');
            let bgColor, borderColor, textColor;

            switch (tipo) {
                case 'success':
                    bgColor = 'bg-green-100';
                    borderColor = 'border-green-400';
                    textColor = 'text-green-700';
                    break;
                case 'error':
                    bgColor = 'bg-red-100';
                    borderColor = 'border-red-400';
                    textColor = 'text-red-700';
                    break;
                case 'info': 
                    bgColor = 'bg-blue-100';
                    borderColor = 'border-blue-400';
                    textColor = 'text-blue-700';
                    break;
                default:
                    bgColor = 'bg-blue-100';
                    borderColor = 'border-blue-400';
                    textColor = 'text-blue-700';
            }

            // Añadido 'temp-message-container' para poder eliminar mensajes anteriores
            container.className = `temp-message-container fixed top-4 left-1/2 -translate-x-1/2 p-4 rounded-lg shadow-lg z-[1000] ${bgColor} ${borderColor} ${textColor} border w-11/12 sm:max-w-md`;
            container.innerHTML = `<p>${mensaje}</p>`;
            document.body.appendChild(container);

            setTimeout(() => {
                container.remove();
            }, 3000); // El mensaje desaparece después de 3 segundos
        }

        document.querySelectorAll(".btn-editar").forEach(boton => {
            boton.addEventListener("click", () => {
                console.log("Botón Editar clickeado.");
                const fila = boton.closest("tr");
                
                if (!fila) {
                    console.error("Error: No se encontró la fila (<tr>) padre del botón Editar.");
                    return;
                }

                console.log("Fila encontrada:", fila);

                // Habilita los inputs para edición y cambia su estilo
                fila.querySelectorAll(".input-editable").forEach(input => {
                    input.removeAttribute("readonly");
                    input.classList.remove("bg-gray-100", "cursor-not-allowed");
                    input.classList.add("bg-white", "focus:ring-2", "focus:ring-pink-600");
                    console.log(`Input ${input.name} habilitado.`);
                });
                
                // Guarda los valores originales de los inputs en el dataset de la fila (tr)
                fila.dataset.originalNombre = fila.querySelector("input[name='nombre']").value;
                fila.dataset.originalMarca = fila.querySelector("input[name='marca']").value;
                fila.dataset.originalCantidad = fila.querySelector("input[name='cantidad']").value;
                fila.dataset.originalPrecioVenta = fila.querySelector("input[name='precio_venta']").value;
                console.log("Valores originales guardados en dataset de la fila.");

                // Muestra los botones Guardar y Cancelar, y oculta el botón Editar
                const btnGuardar = fila.querySelector(".btn-guardar");
                const btnCancelar = fila.querySelector(".btn-cancelar");

                if (btnGuardar) {
                    btnGuardar.classList.remove("hidden");
                    console.log("Botón Guardar mostrado.");
                } else {
                    console.error("Error: No se encontró el botón .btn-guardar dentro de la fila.");
                }

                if (btnCancelar) {
                    btnCancelar.classList.remove("hidden");
                    console.log("Botón Cancelar edición mostrado.");
                } else {
                    console.error("Error: No se encontró el botón .btn-cancelar dentro de la fila.");
                }
                
                boton.classList.add("hidden"); // Oculta el botón "Editar"
                console.log("Botón Editar ocultado.");
            });
        });

        document.querySelectorAll(".btn-cancelar").forEach(boton => {
            boton.addEventListener("click", () => {
                console.log("Botón Cancelar clickeado.");
                const fila = boton.closest("tr"); 

                if (!fila) {
                    console.error("Error: No se encontró la fila (<tr>) padre del botón Cancelar.");
                    return;
                }
                
                // Restaura los valores originales de los inputs desde el dataset de la fila
                fila.querySelector("input[name='nombre']").value = fila.dataset.originalNombre;
                fila.querySelector("input[name='marca']").value = fila.dataset.originalMarca;
                fila.querySelector("input[name='cantidad']").value = fila.dataset.originalCantidad;
                fila.querySelector("input[name='precio_venta']").value = fila.dataset.originalPrecioVenta;
                console.log("Valores restaurados.");

                // Deshabilita los inputs y restaura su estilo
                fila.querySelectorAll(".input-editable").forEach(input => {
                    input.setAttribute("readonly", true);
                    input.classList.add("bg-gray-100", "cursor-not-allowed");
                    input.classList.remove("bg-white", "focus:ring-2", "focus:ring-pink-600");
                    console.log(`Input ${input.name} deshabilitado.`);
                });

                // Oculta los botones Guardar y Cancelar, y muestra el botón Editar
                const btnGuardar = fila.querySelector(".btn-guardar");
                const btnCancelar = fila.querySelector(".btn-cancelar");
                const btnEditar = fila.querySelector(".btn-editar");

                if (btnGuardar) {
                    btnGuardar.classList.add("hidden");
                    console.log("Botón Guardar ocultado.");
                }
                if (btnCancelar) {
                    btnCancelar.classList.add("hidden");
                    console.log("Botón Cancelar edición ocultado.");
                }
                if (btnEditar) {
                    btnEditar.classList.remove("hidden"); // Muestra el botón "Editar"
                    console.log("Botón Editar mostrado.");
                } else {
                    console.error("Error: No se encontró el botón .btn-editar dentro de la fila.");
                }
            });
        });

        // Nuevo listener para el botón Guardar (AJAX)
        document.querySelectorAll(".btn-guardar").forEach(boton => {
            boton.addEventListener("click", async () => {
                console.log("Botón Guardar clickeado.");
                const fila = boton.closest("tr");
                
                if (!fila) {
                    console.error("Error: No se encontró la fila (<tr>) padre del botón Guardar.");
                    mostrarMensaje("Error interno al guardar. Por favor, recarga la página.", "error");
                    return;
                }

                const productId = fila.dataset.productId;
                const nombre = fila.querySelector("input[name='nombre']").value;
                const marca = fila.querySelector("input[name='marca']").value;
                const cantidad = fila.querySelector("input[name='cantidad']").value;
                const precio_venta = fila.querySelector("input[name='precio_venta']").value;

                const formData = new FormData();
                formData.append('id', productId);
                formData.append('nombre', nombre);
                formData.append('marca', marca);
                formData.append('cantidad', cantidad);
                formData.append('precio_venta', precio_venta);

                mostrarMensaje("Guardando cambios...", "info");

                try {
                    const response = await fetch("<?= base_url('panel/editProductProceso') ?>", {
                        method: 'POST',
                        body: formData // FormData se encarga de Content-Type
                    });

                    const result = await response.json(); 

                    if (response.ok && result.success) {
                        mostrarMensaje(result.message || "Producto actualizado con éxito.", "success");
                        // Después de guardar, volver al estado inicial (inputs readonly, botones ocultos/mostrados)
                        fila.querySelectorAll(".input-editable").forEach(input => {
                            input.setAttribute("readonly", true);
                            input.classList.add("bg-gray-100", "cursor-not-allowed");
                            input.classList.remove("bg-white", "focus:ring-2", "focus:ring-pink-600");
                        });
                        fila.querySelector(".btn-guardar").classList.add("hidden");
                        fila.querySelector(".btn-cancelar").classList.add("hidden");
                        fila.querySelector(".btn-editar").classList.remove("hidden");
                    } else {
                        const errorMessage = result.errors ? Object.values(result.errors).join('<br>') : (result.message || "Error al actualizar el producto.");
                        mostrarMensaje(errorMessage, "error");
                        console.error("Error del servidor:", result.errors || result.message);
                    }
                } catch (error) {
                    console.error("Error en la petición AJAX:", error);
                    mostrarMensaje("Error de conexión al servidor. Intenta de nuevo.", "error");
                }
            });
        });
    </script>

<?= $this->endSection() ?>
