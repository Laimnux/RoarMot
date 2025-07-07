<?= $this->extend('Layouts/PanelLayout') ?>

<?= $this->section('content') ?>

    <!-- Alerta visual (Mantener aquí si quieres que sea específica de esta vista) -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
             <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
             <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <h1 class="text-xl font-bold text-gray-800 mb-6">Producto nuevo</h1>

    <!-- El formulario completo -->
    <form action="<?= base_url('panel/ProductProcess'); ?>" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6" onsubmit="return validarFormulario()">
        <!-- Formulario (parte izquierda) -->
        <div class="bg-white p-6 rounded-lg shadow w-full md:flex-1">
            <h2 class="text-base font-semibold text-pink-600 mb-4">Datos generales</h2>

            <div class="flex flex-col sm:flex-row items-center gap-6 mb-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="tipo" value="producto" class="accent-pink-600" checked />
                    <span>Un producto</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="tipo" value="combo" class="accent-pink-600" />
                    <span>En combo</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="tipo" value="servicio" class="accent-pink-600" />
                    <span>Servicio</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <input type="text" name="nombre" placeholder="Nombre del producto *" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                <input type="text" name="marca" placeholder="Marca *" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                <input type="text" name="talla" placeholder="Talla" class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                <input type="number" name="cantidad" placeholder="Cantidad *" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                <input type="text" name="lote" placeholder="Lote" class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                <input type="number" name="precio_venta" placeholder="Precio de venta *" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
            </div>

            <textarea name="descripcion" placeholder="Descripción del producto" rows="3" class="w-full mb-4 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-pink-600 text-gray-800"></textarea>

            <h2 class="text-base font-semibold text-pink-600 mb-2">Inventario</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <select name="categoria" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                    <option value="">Categoría *</option>
                    <option value="casco">Cascos</option>
                    <option value="guantes">Guantes</option>
                    <option value="chaquetas">Chaquetas</option>
                </select>
                <select name="subcategoria" required class="p-2 border rounded border-gray-300 focus:ring-2 focus:ring-pink-600 text-gray-800">
                    <option value="">Subcategoría *</option>
                    <option value="integral">Integral</option>
                    <option value="modular">Modular</option>
                    <option value="abierto">Abierto</option>
                </select>
            </div>
        </div>

        <!-- Área imagen y botón Guardar (parte derecha) -->
        <div class="w-full md:w-80 flex flex-col gap-4 flex-shrink-0">
            <div class="bg-white p-6 rounded-lg shadow flex-1 flex flex-col justify-between">
                <label for="imagen" class="w-full h-48 border border-dashed border-gray-400 flex items-center justify-center cursor-pointer text-gray-500 hover:text-pink-600 text-center text-sm mb-2">
                    <span class="text-sm">+<br>Sube las fotos del producto</span>
                    <input type="file" name="imagen[]" id="imagen" class="hidden" accept="image/*" multiple onchange="previewImagenes(event)" required>
                </label>
                <div id="preview" class="grid grid-cols-4 gap-2"></div>
            </div>
            <button type="submit" class="w-full bg-black text-white py-2 rounded hover:bg-pink-600 transition">Guardar</button>
        </div>
    </form>

    <script>
        // lucide.createIcons(); // Ya se llama en el layout

        function validarFormulario() {
            const nombre = document.querySelector('[name="nombre"]').value.trim();
            const marca = document.querySelector('[name="marca"]').value.trim();
            const cantidad = document.querySelector('[name="cantidad"]').value.trim();
            const precio = document.querySelector('[name="precio_venta"]').value.trim();
            const imagenes = document.querySelector('[name="imagen[]"]').files;

            // Reemplazar alert() con un modal o mensaje en la UI
            if (!nombre || !marca || !cantidad || !precio) {
                // alert("❌ Por favor, completa todos los campos obligatorios.");
                mostrarMensaje("❌ Por favor, completa todos los campos obligatorios.", 'error');
                return false;
            }

            if (imagenes.length === 0) {
                // alert("⚠️ Debes seleccionar al menos una imagen.");
                mostrarMensaje("⚠️ Debes seleccionar al menos una imagen.", 'warning');
                return false;
            }

            return true;
        }

        function previewImagenes(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-12 h-12 object-cover rounded';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

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