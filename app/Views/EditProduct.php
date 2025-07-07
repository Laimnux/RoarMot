<?= $this->extend('Layouts/PanelLayout') ?>

<?= $this->section('content') ?>

    <h1 class="text-xl font-bold text-gray-800 mb-6">Editar o eliminar productos</h1>

    <!-- Mensajes (usando session flashdata de CodeIgniter) -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 border border-green-400 rounded">✅ <?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 border border-red-400 rounded">❌ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Tabla -->
    <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
        <div class="min-w-[900px]">
            <table class="w-full text-left border">
                <thead class="bg-pink-600 text-white">
                    <tr>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Marca</th>
                        <th class="p-2">Cantidad</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <!-- Cada fila es un formulario para editar/eliminar un producto -->
                            <form action="<?= base_url('vendor/edit-product-process') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de guardar los cambios?')">
                                <input type="hidden" name="id" value="<?= esc($producto['ID']) ?>">
                                <td class="p-2">
                                    <input name="nombre" value="<?= esc($producto['NOMBRE']) ?>" class="border border-gray-300 px-2 py-1 rounded w-full text-gray-800" readonly>
                                </td>
                                <td class="p-2">
                                    <input name="marca" value="<?= esc($producto['MARCA']) ?>" class="border border-gray-300 px-2 py-1 rounded w-full text-gray-800" readonly>
                                </td>
                                <td class="p-2">
                                    <input name="cantidad" type="number" value="<?= esc($producto['CANTIDAD']) ?>" class="border border-gray-300 px-2 py-1 rounded w-full text-gray-800" readonly>
                                </td>
                                <td class="p-2">
                                    <input name="precio_venta" type="number" step="0.01" value="<?= esc($producto['PRECIO']) ?>" class="border border-gray-300 px-2 py-1 rounded w-full text-gray-800" readonly>
                                </td>
                                <td class="p-2 flex gap-2">
                                    <button type="button" class="editar bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded text-white">Editar</button>
                                    <button type="submit" name="guardar" class="guardar hidden bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-white">Guardar</button>
                                    <!-- Formulario separado para eliminar para evitar problemas con el formulario de edición -->
                                    <form action="<?= base_url('vendor/delete-product-process') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <input type="hidden" name="id" value="<?= esc($producto['ID']) ?>">
                                        <button type="submit" name="eliminar" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white">Eliminar</button>
                                    </form>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No hay productos para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // lucide.createIcons(); // Ya se llama en el layout

        document.querySelectorAll(".editar").forEach(boton => {
            boton.addEventListener("click", () => {
                const fila = boton.closest("tr");
                // Habilita los inputs para edición
                fila.querySelectorAll("input[name='nombre'], input[name='marca'], input[name='cantidad'], input[name='precio_venta']").forEach(input => input.removeAttribute("readonly"));
                
                // Muestra el botón Guardar y oculta el botón Editar
                fila.querySelector(".guardar").classList.remove("hidden");
                boton.classList.add("hidden");
            });
        });

        // Función para mostrar mensajes (reemplazo de alert)
        function mostrarMensaje(mensaje, tipo) {
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
                case 'warning':
                    bgColor = 'bg-yellow-100';
                    borderColor = 'border-yellow-400';
                    textColor = 'text-yellow-700';
                    break;
                default:
                    bgColor = 'bg-blue-100';
                    borderColor = 'border-blue-400';
                    textColor = 'text-blue-700';
            }

            container.className = `fixed top-4 left-1/2 -translate-x-1/2 p-4 rounded-lg shadow-lg z-[1000] ${bgColor} ${borderColor} ${textColor} border`;
            container.innerHTML = `<p>${mensaje}</p>`;
            document.body.appendChild(container);

            setTimeout(() => {
                container.remove();
            }, 3000); // El mensaje desaparece después de 3 segundos
        }
    </script>

<?= $this->endSection() ?>