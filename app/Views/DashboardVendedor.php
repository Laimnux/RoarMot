<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | RoarMot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #151921;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Estilos para el contenedor principal de los formularios - AHORA PARA EL CONTENEDOR GENERAL DEL MAIN */
        .main-content-wrapper {
            background-color:rgba(26, 32, 44, 0); /* Fondo más oscuro para el contenedor principal */
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #5C7589; /* Borde sutil */
        }

        /* Estilos para las tarjetas de activación (los botones que revelan los formularios) */
        .trigger-card {
            background-color: #2D3748; /* Fondo de las tarjetas de activación */
            border-radius: 0.5rem; /* Bordes redondeados */
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
            border: 1px solid #4A5568; /* Borde sutil */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 150px; /* Altura mínima para que se vean bien */
        }
        .trigger-card:hover {
            background-color: #374151; /* Color al pasar el cursor */
            transform: translateY(-5px); /* Pequeño efecto de elevación */
        }
        .trigger-card h3 {
            color: #FBBF24; /* Amarillo para títulos */
            font-weight: 700;
            margin-top: 0.5rem;
        }
        .trigger-card p {
            color: #CBD5E0;
            font-size: 0.9rem;
        }

        /* Estilos para la subventana del formulario (el popup) */
        .popup-form-window {
            position: absolute;
            /* Posicionamiento: Aparece a la derecha del trigger, ajusta 'left' si necesitas otro lugar */
            top: -100%; 
            left: 0; /* 100% del ancho del padre + el gap */
            width: 400px; /* Ancho fijo para el popup, ajusta según necesidad */
            background-color: #1A202C; /* Fondo del popup */
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada */
            border: 1px solid #5C7589; /* Borde del popup */
            padding: 1.5rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0s linear 0.3s; /* Retraso para visibility */
            transform: translateX(20px) scale(0.95); /* Empieza un poco a la derecha y más pequeño */
            z-index: 60; /* Asegura que esté por encima de todo */
        }
        /* Mostrar el popup al hacer hover sobre el grupo padre */
        .group:hover .popup-form-window {
            opacity: 1;
            visibility: visible;
            transform: translateX(0) scale(1);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out; /* Sin retraso al aparecer */
        }

        /* Estilos para el contenido del formulario dentro del popup */
        .form-content-in-popup {
            display: flex;
            flex-direction: column;
            gap: 1rem; /* Espacio entre los grupos de campos */
        }

        /* Reutilizamos los estilos de field-group y form-input */
        .section-title {
            color: #E2E8F0;
            font-weight: 700;
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #4A5568;
        }
        .field-group {
            border-radius: 0.375rem;
            padding: 0.75rem;
            background-color: #2D3748; /* Fondo para agrupar campos dentro del popup */
            border: 1px solid #4A5568; 
        }
        .form-input {
            background: transparent;
            border: none; 
            border-bottom: 1px solid #6B7280; 
            padding: 0.5rem 0.25rem;
            width: 100%;
            color: #E2E8F0;
            transition: border-color 0.3s ease-in-out;
        }
        .form-input:focus {
            outline: none;
            border-bottom-color: #EF4444; 
        }
        .form-input::placeholder {
            color: #9CA3AF; 
        }
        .moto-image-container {
            width: 100%; 
            height: 268px; 
            background-color: #2D3748; 
            border-radius: 0.5rem;
            border: 1px solid #4A5568;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer; 
        }
        .moto-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Estilos para las tarjetas de la derecha */
        .right-card {
            background-color: #2D3748;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #4A5568;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .right-card h3 {
            color: #FBBF24; 
        }
        .right-card p {
            color: #CBD5E0; 
        }
        /* Estilo para el botón de Guardar Cambios */
        .save-button {
            background-color: #EF4444; 
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }
        .save-button:hover {
            background-color: #DC2626; 
            transform: translateY(-2px); 
        }
        /* Estilos para las secciones inferiores (Imagina esto, Alertas programadas) */
        .bottom-section-card {
            background-color:rgba(45, 55, 72, 0);
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #5C7589;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 1.5rem; 
        }
        .bottom-section-card h3 {
            color: #FBBF24;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        .bottom-section-card p {
            color: #CBD5E0;
            font-size: 0.9rem;
        }
        .bottom-section-card ul {
            list-style: disc;
            margin-left: 1.25rem;
            color: #CBD5E0;
            font-size: 0.9rem;
        }
        .bottom-section-card ul li {
            margin-bottom: 0.5rem;
        }
        /* Animación de destello */
        @keyframes sparkle {
            0% { transform: translateX(-100%) skewX(-30deg); }
            100% { transform: translateX(200%) skewX(-30deg); }
        }

        .sparkle-button {
            position: relative; 
            z-index: 1; 
        }

        .sparkle-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%; 
            height: 100%;
            background: rgba(255, 255, 255, 0.3); 
            transform: translateX(-100%) skewX(-30deg); 
            transition: none; 
            pointer-events: none; 
            z-index: 2; 
        }

        .sparkle-button:hover::before {
            animation: sparkle 0.8s ease-in-out forwards; 
        }
    </style>
</head>

<body class="bg-[#151921] text-white">
    <h1> - Hola Bienvenido Vendedor - </h1>
    <!-- Header -->
    <header class="bg-[#151921] shadow-md">
    <!-- El nav principal ahora usa justify-between para distribuir los 3 grupos -->
        <nav class="flex flex-col md:flex-row items-center justify-between p-2 bg-[#151921] gap-2">
            <!-- Grupo 1: Logo  -->
            <div class="flex items-center space-x-0 raunded-lg transition transform hover:scale-110 ml-5">
                <img src="<?= base_url('public/images/assets/Logo-RoarMot-Blanco.png') ?>" alt="Logo RoarMot" class="h-12">
                <img src="<?= base_url('public/images/assets/tipografia-roardmot-blanco.png') ?>" alt="RoarMot" class="h-8">
            </div>
            
            <!-- Grupo 2: Menú principal -->
            <!-- Este div ahora es el contenedor directo del menú central -->
            <div class="flex items-center p-2 rounded-lg gap-1 md:gap-2">
                <button class="flex items-center px-3 py-2 hover:bg-gray-700 rounded-lg transition transform hover:scale-110">
                    <img src=<?= base_url('public/images/assets/barraMenu/iconos-panel-de-control-blanco2.png');?> alt="Panel" class="h-5">
                    <span class="hidden sm:inline ml-1">Panel de control</span>
                </button>
                <button class="flex items-center px-3 py-2 hover:bg-gray-700 rounded-lg transition transform hover:scale-110 mr-3 ml-3">
                    <img src=<?= base_url('public/images/assets/barraMenu/icono-CDA-blanco.png');?> alt="CDA" class="h-5">
                    <span class="hidden sm:inline ml-1">CDA</span>
                </button>
                <button class="flex items-center px-3 py-2 hover:bg-gray-700 rounded-lg transition transform hover:scale-110">
                    <img src=<?= base_url('public/images/assets/barraMenu/iconos-alerta-blanco.png');?> alt="Alertas" class="h-5">
                    <span class="hidden sm:inline ml-1">Alertas</span>
                </button>
                <button class="flex items-center px-3 py-2 hover:bg-gray-700 rounded-lg transition transform hover:scale-110 mr-3 ml-3">
                    <img src=<?= base_url('public/images/assets/barraMenu/simbolo-tiendaBlanco.png');?> alt="Tienda" class="h-5">
                    <span class="hidden sm:inline ml-1">Tienda</span>
                </button>
                <button class="px-3 py-2 hover:bg-red-500 rounded-lg transition transition transform hover:scale-125">
                    <span class="sm:hidden">🆘</span>
                    <span class="hidden sm:inline ">SOS</span>
                </button>
            </div>

            <!-- Grupo 3: Botones adicionales y Perfil de Usuario -->
            <div class="flex items-center gap-2">
                <!-- Botón "Comprar accesorio" con efecto de destello -->
                <button class="sparkle-button bg-yellow-500 px-4 py-2 rounded-lg text-black hover:bg-[#D90D58] transition transform hover:scale-110 whitespace-nowrap relative overflow-hidden">
                    Comprar accesorio
                </button>
                 <button class="p-2 hover:bg-gray-700 rounded-full transition transform hover:scale-125 ml-2 mr-2">
                    <img src=<?= base_url('public/images/assets/barraMenu/icono-universalidad-blanco.png');?> alt="Idioma" class="h-5 w-5">
                </button>
                
                <!-- Contenedor del botón de configuración y el dropdown de perfil -->
                <div class="relative group"> <!-- Añadido 'group' para el hover del padre -->
                    <button class="p-2 hover:bg-gray-700 rounded-full transition transform hover:scale-125 mr-3">
                        <img src=<?= base_url('public/images/assets/barraMenu/iconos-configuracion-blanco-2.png');?> alt="Configuración" class="h-5 w-5">
                    </button>

                    <!-- Dropdown de Perfil -->
                    <div class="absolute right-0 mt-2 w-72 bg-[#1A242C] rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 group-hover:scale-100 z-50 border border-[#5C7589]">
                        <!-- Línea separadora 1 -->
                        <div class="flex items-center p-4 border-b border-[#5C7589]">
                            <!-- Imagen de perfil (placeholder o real si tienes una URL) -->
                            <label for="profileUpload" class="relative w-16 h-16 flex-shrink-0 cursor-pointer overflow-hidden rounded-lg border border-gray-600 flex items-center justify-center bg-gray-800">
                                <img id="profilePreview" src="https://placehold.co/60x60/4A5568/FFFFFF?text=User" alt="Avatar de Usuario" class="w-full h-full object-cover">
                                <!-- Icono de cámara para indicar que es clicable -->
                                <div id="profileUploadArea" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white opacity-0 hover:opacity-100 transition-opacity duration-200">
                                    <i class="fas fa-camera text-xl"></i>
                                </div>
                                <input type="file" id="profileUpload" accept="image/*" class="hidden" onchange="previewImage(this, 'profilePreview', 'profileUploadArea')">
                            </label>
                            <!-- Información de la persona -->
                            <div class="ml-3">
                                <p class="text-white font-semibold text-base"><?= esc($NOMBRE_USUARIO ?? 'Usuario') ?></p>
                                <p class="text-gray-400 text-sm"><?= esc($EMAIL_USUARIO ?? 'correo@ejemplo.com') ?></p>
                            <span class="text-xs text-gray-500 mt-1 block"><?= esc($rol_nombre ?? 'Rol') ?> habitual</span>
                        </div>
                        </div>
                        <!-- Línea separadora 1 p-4 border-b border...-->
                        <div class="p-4 border-b border-[#5C7589]">
                            <p class="text-gray-300 text-sm font-semibold mb-2">Más opciones de configuración</p>
                            <!-- Aquí podrías añadir más enlaces o información -->
                        </div>
                        <a href="<?php echo base_url('panel/panelInicio');?>" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition rounded-b-lg">
                            <i class="fas fa-cog mr-3 text-lg"></i>
                            Panel Proveedor
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition rounded-b-lg">
                            <i class="fas fa-cog mr-3 text-lg"></i>
                            Configuración de la cuenta
                        </a>
                        <a href="<?= base_url('cerrarSesion'); ?>" class="flex items-center px-4 py-3 text-red-500 hover:bg-gray-700 transition rounded-b-lg">
                            <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
                <!-- Fin del contenedor del botón de configuración y el dropdown de perfil -->
            </div>
        </nav>
    </header>

    <!-- Barra divisoria roja -->
    <div class="h-[1.2px] w-full bg-gradient-to-r from-transparent via-red-600 to-transparent shadow-lg shadow-red-600/10"></div>

    <!-- Contenido principal -->
    <!-- Contenido principal -->
    <main class="mx-auto p-4 md:p-8 max-w-full xl:max-w-screen-xl"> 
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 main-content-wrapper"> 
            <!-- Columna izquierda: Tarjetas de activación de formularios (2/3 del ancho) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- Tarjeta de activación 1: Datos Básicos Moto -->
                <div class="relative group">
                    <div class="trigger-card">
                        <i class="fas fa-motorcycle text-4xl text-yellow-500 mb-2"></i>
                        <h3 class="text-xl font-semibold">Datos Básicos de la Moto</h3>
                        <p class="text-gray-400 text-sm">Placa, número de serie, motor, marca, color.</p>
                    </div>
                    <!-- Subventana del formulario de Datos Básicos -->
                    <div class="popup-form-window">
                        <div class="form-content-in-popup">
                            <h2 class="section-title">Datos básicos de la moto</h2>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Placa</label>
                                <input type="text" class="form-input" placeholder="ABC-123">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Número de serie</label>
                                <input type="text" class="form-input" placeholder="XYZ123456789">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Número de motor</label>
                                <input type="text" class="form-input" placeholder="MTR987654321">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Marca / Modelo</label>
                                <input type="text" class="form-input" placeholder="Yamaha YZF-R3">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Color</label>
                                <input type="text" class="form-input" placeholder="Rojo">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de activación 2: Datos Técnicos / Mecánicos -->
                <div class="relative group">
                    <div class="trigger-card">
                        <i class="fas fa-tools text-4xl text-yellow-500 mb-2"></i>
                        <h3 class="text-xl font-semibold">Datos Técnicos / Mecánicos</h3>
                        <p class="text-gray-400 text-sm">Kilometraje, combustible, batería, presión de llantas.</p>
                    </div>
                    <!-- Subventana del formulario de Datos Técnicos -->
                    <div class="popup-form-window">
                        <div class="form-content-in-popup">
                            <h2 class="section-title">Datos técnicos / Mecánicos</h2>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Kilometraje actual</label>
                                <input type="number" class="form-input" placeholder="25000">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Tipo de combustible</label>
                                <select class="form-input bg-transparent">
                                    <option class="bg-[#2D3748] text-white">Gasolina</option>
                                    <option class="bg-[#2D3748] text-white">Diésel</option>
                                    <option class="bg-[#2D3748] text-white">Eléctrico</option>
                                </select>
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Capacidad del tanque (litros)</label>
                                <input type="number" step="0.1" class="form-input" placeholder="14.5">
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Presión recomendada de llantas (PSI)</label>
                                <div class="flex gap-4">
                                    <input type="number" placeholder="Delantera" class="form-input flex-1">
                                    <input type="number" placeholder="Trasera" class="form-input flex-1">
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Batería</label>
                                <input type="text" class="form-input" placeholder="12V 7Ah">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de activación 3: Documentación Legal -->
                <div class="relative group">
                    <div class="trigger-card">
                        <i class="fas fa-file-alt text-4xl text-yellow-500 mb-2"></i>
                        <h3 class="text-xl font-semibold">Documentación Legal</h3>
                        <p class="text-gray-400 text-sm">SOAT, revisión técnico-mecánica, tarjeta de propiedad.</p>
                    </div>
                    <!-- Subventana del formulario de Documentación Legal -->
                    <div class="popup-form-window">
                        <div class="form-content-in-popup">
                            <h2 class="section-title">Documentación Legal</h2>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">SOAT vigente hasta</label>
                                <div class="flex items-center gap-2">
                                    <input type="date" class="form-input flex-1">
                                    <span class="text-gray-400 text-sm">o</span>
                                    <label for="soatUpload" class="bg-[#EF4444] hover:bg-[#DC2626] px-3 py-1 rounded text-sm transition cursor-pointer whitespace-nowrap">
                                        Subir PDF
                                        <input type="file" id="soatUpload" accept=".pdf" class="hidden">
                                    </label>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Revisión técnico-mecánica</label>
                                <label for="tecnomecanicaUpload" class="w-full bg-[#1F2937] hover:bg-[#374151] p-2 text-left text-sm transition rounded cursor-pointer block">
                                    Seleccionar archivo...
                                    <input type="file" id="tecnomecanicaUpload" accept=".pdf" class="hidden">
                                </label>
                            </div>
                            <div class="field-group">
                                <label class="block text-sm text-gray-400 mb-1">Tarjeta de propiedad o título</label>
                                <input type="text" class="form-input" placeholder="Número de tarjeta">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de guardar (se mantiene fuera de los popups para guardar todo) -->
                <div class="p-0 text-right mt-0">
                    <button type="button" class="save-button">
                        Guardar Cambios
                    </button>
                </div>
            </div>

            <!-- Columna derecha (1/3 del ancho) -->
            <div class="flex flex-col gap-6">
                <!-- Imagen de moto -->
                <label for="motoUpload" class="moto-image-container relative">
                    <img id="motoPreview" src="" alt="Foto de tu moto" class="hidden">
                    <div id="uploadArea" class="flex flex-col items-center justify-center h-full w-full p-4 text-gray-400">
                        <i class="fas fa-camera text-4xl mb-3"></i>
                        <p class="text-center">Sube foto de tu moto<br><span class="text-sm">(383×268 px)</span></p>
                    </div>
                    <input type="file" id="motoUpload" accept="image/*" class="hidden" onchange="previewImage(this, 'motoPreview', 'uploadArea')">
                </label>

                <!-- Tarjetas de contenido adicional -->
                <div class="right-card">
                    <h3 class="font-bold text-lg">Nuestros accesorios</h3>
                    <p class="mt-2 text-sm">Encuentra todo lo que necesitas para tu moto.</p>
                </div>
                
                <div class="right-card">
                    <h3 class="font-bold text-lg">Renueva tu SOAT</h3>
                    <p class="mt-2 text-sm">De manera rápida y segura.</p>
                </div>

                <!-- Sección "Imagina esto" -->
                <div class="bottom-section-card">
                    <h3 class="font-bold text-lg">Imagina esto</h3>
                    <p class="mt-2 text-sm">Estás en carretera, tu moto empieza a hacer ese ruido raro. ¿No sería genial saber de inmediato si es algo simple o grave?</p>
                    <ul class="mt-2 text-sm">
                        <li>Saber si es la banda de frenos o el disco.</li>
                        <li>Si hay fugas de aceite o es solo condensación.</li>
                        <li>Si el sistema eléctrico está en corto o solo un fusible.</li>
                    </ul>
                    <p class="mt-2 text-sm">Con RoarMot, puedes diagnosticar problemas en el sistema y tomar los puntos.</p>
                </div>
                
                <!-- Sección "Alertas programadas" -->
                <div class="bottom-section-card">
                    <h3 class="font-bold text-lg">Alertas programadas</h3>
                    <p class="mt-2 text-sm">Aquí verás tus alertas personalizadas para mantenimientos, documentos y más.</p>
                    <div class="mt-4 text-gray-500 text-center">
                        <p>No tienes alertas programadas por ahora.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Función genérica para previsualizar imágenes
        function previewImage(input, previewId, uploadAreaId) {
            const preview = document.getElementById(previewId);
            const uploadArea = document.getElementById(uploadAreaId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Asegura que la imagen se muestre
                    if (uploadArea) { // Oculta el área de carga si existe
                        uploadArea.classList.add('hidden');
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                // Si no se selecciona ningún archivo, muestra el placeholder y el área de carga
                preview.src = preview.dataset.defaultSrc || ''; // Usa un defaultSrc si lo tienes
                preview.classList.remove('hidden'); // Asegura que el placeholder se muestre
                if (uploadArea) {
                    uploadArea.classList.remove('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const soatUploadInput = document.getElementById('soatUpload');
            const tecnomecanicaUploadInput = document.getElementById('tecnomecanicaUpload');

            soatUploadInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    console.log('SOAT seleccionado:', this.files[0].name);
                }
            });

            tecnomecanicaUploadInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    console.log('Tecnomecánica seleccionada:', this.files[0].name);
                }
            });

            // Inicializar la imagen de perfil si ya hay una por defecto
            const profilePreview = document.getElementById('profilePreview');
            const profileUploadArea = document.getElementById('profileUploadArea');
            if (profilePreview && profilePreview.src && profilePreview.src !== window.location.href) { 
                profileUploadArea.classList.add('hidden');
            } else {
                profilePreview.classList.add('hidden'); 
                profileUploadArea.classList.remove('hidden');
            }

            // Modificar la llamada a previewImage para la imagen de la moto
            const motoUploadInput = document.getElementById('motoUpload');
            if (motoUploadInput) {
                motoUploadInput.onchange = function() {
                    previewImage(this, 'motoPreview', 'uploadArea');
                };
            }
        });
    </script>
</body>
</html>
