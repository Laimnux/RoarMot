<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?? 'Panel Proveedor - ROARMOT' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Puedes añadir aquí cualquier estilo global o específico del layout */
    </style>
</head>
<body class="bg-gray-200 flex font-sans min-h-screen text-sm">

    <!-- Sidebar -->
    <aside class="w-72 bg-gray-900 text-white p-6 flex flex-col">
        <div class="mb-12">
            <div class="flex items-center border-b border-pink-600 pb-4 mb-6">
                <img src="<?= base_url('public/images/assets/Logo-RoarMot-Blanco.png') ?>" alt="Logo casco" class="w-14 h-14 object-contain" />
                <img src="<?= base_url('public/images/assets/tipografia-roardmot-blanco.png') ?>" alt="Nombre ROARMOT" class="h-14 object-contain ml-1 -translate-x-5 transform" />
            </div>
            <nav class="space-y-4">
                <!-- Los enlaces ahora apuntan a rutas de CodeIgniter -->
                <a href="<?= base_url('panel/panelInicio') ?>" class="flex items-center gap-3 px-4 py-2 <?= (current_url() == base_url('panel/panelInicio')) ? 'bg-pink-600' : 'bg-gray-800 hover:bg-pink-600' ?> rounded transition">
                    <i data-lucide="home" class="w-5 h-5"></i><span>Inicio</span>
                </a>
                <a href="<?= base_url('panel/addProduct') ?>" class="flex items-center gap-3 px-4 py-2 <?= (current_url() == base_url('panel/addProduct')) ? 'bg-pink-600' : 'bg-gray-800 hover:bg-pink-600' ?> rounded transition">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i><span>Agregar producto</span>
                </a>
                <a href="<?= base_url('panel/editarProduct') ?>" class="flex items-center gap-3 px-4 py-2 <?= (current_url() == base_url('spanel/editarProduct')) ? 'bg-pink-600' : 'bg-gray-800 hover:bg-pink-600' ?> rounded transition">
                    <i data-lucide="edit" class="w-5 h-5"></i><span>Editar producto</span>
                </a>
                <a href="<?= base_url('seller-dashboard/orders') ?>" class="flex items-center gap-3 px-4 py-2 <?= (current_url() == base_url('seller-dashboard/orders')) ? 'bg-pink-600' : 'bg-gray-800 hover:bg-pink-600' ?> rounded transition">
                    <i data-lucide="package" class="w-5 h-5"></i><span>Pedidos</span>
                </a>
                <a href="<?= base_url('seller-dashboard/profile') ?>" class="flex items-center gap-3 px-4 py-2 <?= (current_url() == base_url('seller-dashboard/profile')) ? 'bg-pink-600' : 'bg-gray-800 hover:bg-pink-600' ?> rounded transition">
                    <i data-lucide="user" class="w-5 h-5"></i><span>Perfil</span>
                </a>
                <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-4 py-2 bg-red-600 rounded hover:bg-red-700 transition mt-10">
                    <i data-lucide="log-out" class="w-5 h-5"></i><span>Cerrar sesión</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Panel principal - Aquí se inyectará el contenido específico de cada vista -->
    <main class="flex-1 p-10 overflow-auto relative">
        <!-- ✅ Bienvenida superpuesta -->
        <div class="absolute top-4 right-6 text-sm bg-white px-4 py-2 rounded shadow border border-gray-200 z-10">
            Bienvenido, <span class="font-semibold text-pink-600"><?= esc($NOMBRE_USUARIO ?? 'Usuario') ?></span>
        </div>

        <!-- Renderiza el contenido específico de la vista que extiende este layout -->
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>