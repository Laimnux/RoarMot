<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home MYMoto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fuente personalizada -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .font-bebas {
            font-family: 'Bebas Neue', sans-serif;
        }
        /* Animación personalizada para el pulso */
        @keyframes customPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .animate-custom-pulse {
            animation: customPulse 3s ease-in-out infinite;
        }
        
        /* Consolidamos el fondo en #hero para mejor control */
        #hero {
            background: linear-gradient(rgba(0, 0, 0, 0.171), rgba(0, 0, 0, 0.747)), 
            url('<?php echo base_url('public/images/assets/fondoPagina.jpg');?>') center/cover no-repeat fixed;
        }

        /* Animación gradiente para el titulo de descargar la app */
        @keyframes gradient-wave {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }
        .animated-text-gradient {
            background-size: 200% 100%; /* Asegura que el gradiente sea más grande que el texto */
            animation: gradient-wave 3s ease infinite alternate; /* Aplica la animación */
        }

        html {
            scroll-behavior: smooth;
        }

        /* Estilos para el menú móvil */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 40; /* Menor que el menú, mayor que el contenido */
            display: none; /* Oculto por defecto */
        }
        .mobile-menu-content {
            position: fixed;
            top: 0;
            right: 0;
            width: 75%; /* Ancho del menú móvil */
            max-width: 300px; /* Ancho máximo para pantallas más grandes */
            height: 100%;
            background-color: #101010;
            z-index: 50;
            transform: translateX(100%); /* Oculto a la derecha */
            transition: transform 0.3s ease-out;
            padding: 1.5rem;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
            display: flex; /* Usar flex para organizar los elementos */
            flex-direction: column;
        }
        .mobile-menu-content.open {
            transform: translateX(0); /* Muestra el menú */
        }
    </style>
</head>
<body id="Top" class="bg-gray-900"> <!-- Fondo oscuro en el body para el hero -->

    <!-- ==================== -->
    <!-- MENÚ SUPERIOR -->
    <!-- ==================== -->
    <header class="bg-[#101010] text-white sticky top-0 z-50 shadow-xl">
        <div class="container mx-auto px-4 py-2 flex items-center justify-between">

            <!--logos de la marca-->
            <div class="flex items-center">
                <a href="#Top" class="block transition-transform duration-300 hover:scale-105"> 
                    <img src="<?php echo base_url('public/images/assets/Logo-RoarMot-Blanco.png');?>" alt="Logo RoarMot" 
                        class="h-10 sm:h-12 w-auto object-contain">
                </a>
                <a href="#Top" class="block transition-transform duration-300 hover:scale-105"> 
                    <img src="<?php echo base_url('public/images/assets/tipografia-roardmot-blanco.png');?>"
                        alt="Tipografía RoarMot" class="w-auto h-7 sm:h-8 ml-1 md:ml-2 max-w-[150px] object-contain">
                </a>
            </div>
            
            <!-- Menú central (Desktop) -->
            <nav class="hidden md:flex space-x-6 lg:space-x-8">
                <a href="#Tienda" class="text-sm lg:text-base hover:text-red-400 transition-colors font-medium
                flex items-center justify-center h-full px-2 py-1
                border-b-2 border-transparent hover:border-orange-400">Tienda</a>
                <a href="#CDA" class="text-sm lg:text-base hover:text-red-400 transition-colors font-medium
                flex items-center justify-center h-full px-2 py-1
                border-b-2 border-transparent hover:border-orange-400">CDA</a>
                <a href="#Alerta" class="text-sm lg:text-base hover:text-red-400 transition-colors font-medium
                flex items-center justify-center h-full px-2 py-1
                border-b-2 border-transparent hover:border-orange-400">Alertas</a>
                <a href="#sos" class="text-sm lg:text-base hover:text-red-400 transition-colors font-medium
                flex items-center justify-center h-full px-2 py-1
                border-b-2 border-transparent hover:border-orange-400">SOS</a>
            </nav>
            
            <!-- Sección usuario (Desktop) -->
            <div class="hidden md:flex items-center space-x-3 lg:space-x-4">
                <a href="<?php echo base_url('iniciarSesion');?>" 
                    class="text-sm lg:text-base hover:text-red-400 transition-all duration-300 font-medium
                           flex items-center justify-center h-full px-2 py-1
                           border-b-2 border-transparent hover:border-orange-400
                           group relative overflow-hidden">
                    <span class="relative z-10">Iniciar sesión</span>
                    <span class="absolute inset-0 bg-orange-000 opacity-0 
                                  group-hover:opacity-10 transition-opacity duration-500"></span>
                </a>
                <a href="<?php echo base_url('registro/paso1');?>" class="bg-red-600 hover:bg-[#fd8c00] text-white 
                        px-3 py-1 lg:px-4 lg:py-2 rounded-lg 
                        font-bold tracking-wide text-sm lg:text-base
                        transition-all duration-150 transform hover:scale-105 
                        shadow-lg hover:shadow-xl hover:brightness-110">
                    REGÍSTRATE
                </a>
            </div>

            <!-- Mobile Menu Button (Hamburger) -->
            <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

        <!-- Mobile Menu Content (initially hidden) -->
        <div id="mobile-menu-content" class="mobile-menu-content">
            <div class="flex justify-end mb-6">
                <button id="close-mobile-menu" class="text-white text-2xl focus:outline-none">&times;</button>
            </div>
            <nav class="flex flex-col space-y-4 flex-grow">
                <a href="#Tienda" class="block text-white hover:text-red-400 transition-colors py-2 text-lg font-medium">Tienda</a>
                <a href="#CDA" class="block text-white hover:text-red-400 transition-colors py-2 text-lg font-medium">CDA</a>
                <a href="#Alerta" class="block text-white hover:text-red-400 transition-colors py-2 text-lg font-medium">Alertas</a>
                <a href="#sos" class="block text-white hover:text-red-400 transition-colors py-2 text-lg font-medium">SOS</a>
            </nav>
            <div class="border-t border-gray-700 pt-6 mt-6 space-y-4">
                <a href="<?php echo base_url('iniciarSesion');?>" class="block text-white hover:text-red-400 transition-colors py-2 text-lg font-medium text-center">Iniciar sesión</a>
                <a href="<?php echo base_url('registro/paso1');?>" class="block bg-red-600 hover:bg-[#fd8c00] text-white text-center px-4 py-3 rounded-lg font-bold text-lg">REGÍSTRATE</a>
            </div>
        </div>
    </header>

    <!-- ==================== -->
    <!-- CONTENIDO PRINCIPAL -->
    <!-- ==================== -->
    <main class="relative z-10">

        <section id="hero" class="min-h-screen flex items-center justify-center md:justify-end relative text-center md:text-left">
            <div class="container mx-auto pt-18 pb-8 md:pb-16 text-white px-4 md:px-8 lg:px-16 md:mr-16 lg:mr-24">
                <div class="max-w-md mx-auto md:mx-0">

                    <h1 class="font-bebas text-5xl sm:text-6xl md:text-6xl lg:text-7xl mb-4 tracking-wider leading-tight">
                        TU MOTO, TU CONTROL
                    </h1>

                    <p class="font-[Arial_Black] text-3xl sm:text-4xl md:text-4xl 
                        bg-clip-text text-transparent 
                        bg-gradient-to-r from-red-500 to-yellow-500 
                        drop-shadow-[0_0_8px_#ff000080] mb-8 leading-tight">
                        Accede y gestiona 
                        todo desde la palma de tu mano.
                    </p>

                    <p class="text-lg md:text-xl mb-8 mt-2 text-gray-300 font-medium leading-relaxed italic">
                        Controla y gestiona tu moto de forma remota en tu dispositivo móvil descargando nuestra app.
                    </p>

                    <a href="<?php echo base_url('registro/paso1');?>" class="inline-block 
                          text-3xl md:text-4xl font-bebas 
                          px-12 md:px-16 py-4 md:py-6 
                          bg-red-600 hover:bg-[#fd8c00] mt-4
                          text-white 
                          rounded 
                          tracking-widest
                          transition-all duration-150 
                          transform scale-90 hover:scale-100
                          hover:brightness-120
                          border-2 border-transparent">
                      REGÍSTRATE
                    </a>
                    
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 w-full text-center px-4 "> 
                <div class="group inline-block mb-16">
                    <p class="text-3xl sm:text-4xl md:text-4xl italic font-bold relative 
                                bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-red-500
                                [text-shadow:_0_0_30px_#ff0000,0_0_10px_#ff00000]
                                animate-custom-pulse hover:animate-none">
                        "MOTERO AYUDA MOTERO"
                        <span class="absolute bottom-0 left-0 h-0.5 w-0 bg-yellow-500 
                                     group-hover:w-full transition-all duration-300"></span>
                        <span class="absolute inset-5 bg-yellow-500 opacity-0 
                                     group-hover:opacity-10 group-hover:scale-110 
                                     transition-all duration-200 blur-sm"></span>
                    </p>
                </div>
            </div>

        </section>
        
    </main>

    <!-- ===== SEPARADOR INVISIBLE ===== -->
    <div class="py-5 bg-gray-50"></div>


    <!-- ===== SECCIÓN APP CENTRADA Descarga nuestra app ===== -->
    <section id="DescargarApp" class="py-16 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto bg-gray-900 rounded-xl shadow-2xl"> 
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-8 md:p-12 space-y-6 font-inter bg-[#252625]">
                        <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white font-bebas tracking-wide leading-tight">
                            LLEVA TU AVENTURA AL 
                            <span class="block bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600 bg-[length:200%_100%] bg-clip-text text-transparent animated-text-gradient">
                                SIGUIENTE NIVEL
                            </span>
                        </h2>
                        <p class="text-gray-300 text-base md:text-lg">
                            Con nuestra aplicación, obtén el control de tu moto y disfruta cada viaje. Descubre las funcionalidades exclusivas para ti Motero al alcance de tu mano y estés donde estés.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6"> 
                            
                            <div class="flex items-start gap-3 bg-gray-800 p-4 rounded-lg shadow-inner
                                         transform transition-all duration-300 hover:scale-105 hover:bg-[#9AEBA3]"> 
                                <div class="flex-shrink-0 p-2 bg-red-700 rounded-full"> 
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-md font-semibold text-white mb-1">Doc. Legal Digital</h4>
                                    <p class="text-gray-400 text-sm">Lleva todos tus papeles seguros en la app, siempre a mano.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gray-800 p-4 rounded-lg shadow-inner
                                         transform transition-all duration-300 hover:scale-105 hover:bg-[#9AEBA3]"> 
                                <div class="flex-shrink-0 p-2 bg-orange-600 rounded-full">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-md font-semibold text-white mb-1">Tienda RoarMot Integrada</h4>
                                    <p class="text-gray-400 text-sm">Accesorios premium para ti y tu moto, directo en la app.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gray-800 p-4 rounded-lg shadow-inner
                                         transform transition-all duration-300 hover:scale-105 hover:bg-[#9AEBA3]"> 
                                <div class="flex-shrink-0 p-2 bg-blue-600 rounded-full">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-md font-semibold text-white mb-1">Sistema SOS Inteligente</h4>
                                    <p class="text-gray-400 text-sm">Conéctate con contactos de emergencia al instante.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 bg-gray-800 p-4 rounded-lg shadow-inner
                                         transform transition-all duration-300 hover:scale-105 hover:bg-[#9AEBA3]"> 
                                <div class="flex-shrink-0 p-2 bg-green-600 rounded-full">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M17 11h.01M12 11h.01M7 11h.01M12 15h.01M17 15h.01M7 15h.01M4 12v6a2 2 0 002 2h12a2 2 0 002-2v-6M4 8h16V5a2 2 0 00-2-2H6a2 2 0 00-2 2v3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-md font-semibold text-white mb-1">Renovación CDA y SOAT</h4>
                                    <p class="text-gray-400 text-sm">Gestiona y renueva tu documentación de forma ágil.</p>
                                </div>
                            </div>

                        </div> 
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-8">
                            <div class="relative group"> 
                                <a href="#" class="transition-transform hover:scale-105 transform">
                                    <img src="<?php echo base_url('public/images/assets/google-play.png');?>" alt="Descargar en Google Play" class="h-14 md:h-16">
                                </a>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1 bg-[#025951] text-white text-xs rounded whitespace-nowrap
                                            transform translate-x-full opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 overflow-hidden">
                                    Descarga nuestra app RoarMot
                                </div>
                            </div>
                            <!-- Puedes añadir un botón para Apple App Store aquí si lo necesitas -->
                        </div>
                    </div>
                    <div class="lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-yellow-300 to-red-500 relative overflow-hidden">
                        <div class="relative w-full max-w-xs sm:max-w-sm lg:max-w-md xl:max-w-sm">
                            <img src="<?php echo base_url('public/images/assets/Telefono-con-la-app.png');?>" alt="Pantalla de la aplicación MYMOTO en un smartphone mostrando monitoreo en tiempo real" class="w-full h-auto drop-shadow-2xl transition-transform duration-300 hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LINEA SEPARADORA ===== -->
    <div class="py-4 bg-gray-50"> 
        <div class="container mx-auto px-4">
            <div class="max-w-full mx-auto"> 
                <hr class="border-t-[1px] border-red-600 my-4">
            </div>
        </div>
    </div>

    <!-- ===== SECCIÓN TIENDA (FONDO CLARO) ===== -->
    <section id="Tienda" class="py-16 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto xl:max-w-7xl">
                
                <div class="mb-12 md:mb-16 flex flex-col md:flex-row md:justify-between md:items-end text-center md:text-left">
                    
                    <div class="md:w-1/2 mb-8 md:mb-0">
                        <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 font-bebas tracking-wide [text-shadow:_1px_1px_2px_rgba(0,0,0,0.1)] leading-tight">
                            TIENDA 
                            <span class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600 bg-clip-text text-transparent">RoarMot</span>
                        </h2>
                    </div>

                    <div class="md:w-1/2">
                        <p class="text-gray-700 text-lg md:text-xl font-semibold max-w-xl mx-auto md:mx-0">
                            Descubre un mundo de posibilidades en cada viaje,
                            equípate con los mejores accesorios para moteros.
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200">
                        <div class="relative h-60 overflow-hidden group">
                            <img src="<?php echo base_url('public/images/assets/casco 3.jpeg');?>" alt="Casco" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <span class="absolute top-4 right-4 bg-orange-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">NUEVO</span>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-bold text-gray-900">Casco Vortex Pro</h3>
                                <span class="text-orange-600 font-bold">⭐ 4.8</span>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm">Tecnología anti-vaho y peso ultra ligero</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-gray-900 font-bold text-lg">$320.000</span>
                                <button class="bg-gray-900 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                                    Añadir al carrito
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200">
                        <div class="relative h-60 overflow-hidden group">
                            <img src="<?php echo base_url('public/images/assets/guantes.jpg');?>" alt="Guantes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">-25%</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Guantes Carbon Flex</h3>
                            <p class="text-gray-600 mt-2 text-sm">Protección nivel 2 con flexibilidad máxima</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div>
                                    <span class="text-orange-600 font-bold text-lg">$112.500</span>
                                    <span class="text-gray-400 line-through text-sm block">$150.000</span>
                                </div>
                                <button class="bg-gray-900 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                                    Añadir al carrito
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200">
                        <div class="relative h-60 overflow-hidden group">
                            <img src="<?php echo base_url('public/images/assets/chaqueta.jpeg');?>" alt="Chaqueta" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Chaqueta Stormguard</h3>
                            <p class="text-gray-600 mt-2 text-sm">Impermeable con protecciones extraíbles</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-gray-900 font-bold text-lg">$275.000</span>
                                <button class="bg-gray-900 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                                    Añadir al carrito
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-12">
                    <a href="#" class="inline-block bg-gray-900 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        Ver catálogo completo →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LINEA SEPARADORA ===== -->
    <div class="py-4 bg-gray-50"> 
        <div class="container mx-auto px-4">
            <div class="max-w-full mx-auto"> 
                <hr class="border-t-[1px] border-red-600 my-4">
            </div>
        </div>
    </div>

    <!-- ===== SECCIÓN CDA ===== -->
    <section id="CDA" class="py-16 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Contenedor principal centrado -->
            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                
                <!-- Encabezado con icono -->
                <div class="bg-[#151921] p-8 text-center">
                    <div class="inline-flex items-center justify-center bg-orange-500 rounded-full w-14 h-14 sm:w-16 sm:h-16 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white font-bebas tracking-wide">
                        CENTRO DE DOCUMENTACIÓN <span class="text-orange-400">AUTOMOTOR</span>
                    </h2>
                    <p class="text-gray-300 mt-2 text-base md:text-lg">
                        Renueva tus documentos sin filas y desde cualquier lugar
                    </p>
                </div>

                <!-- Contenido CDA -->
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                    
                    <!-- Columna izquierda - Beneficios -->
                    <div class="p-8 md:p-10">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                            ¿Por qué renovar con nosotros?
                        </h3>
                        
                        <ul class="space-y-5">
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-orange-100 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Proceso 100% digital</h4>
                                    <p class="text-gray-600 mt-1 text-sm">Sin visitar oficinas ni hacer filas interminables</p>
                                </div>
                            </li>
                            
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-orange-100 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Seguimiento en tiempo real</h4>
                                    <p class="text-gray-600 mt-1 text-sm">Recibe notificaciones de cada etapa del trámite</p>
                                </div>
                            </li>
                            
                            <li class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-orange-100 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Ahorro garantizado</h4>
                                    <p class="text-gray-600 mt-1 text-sm">Hasta 20% más económico que trámites tradicionales</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Columna derecha - Formulario -->
                    <div class="p-8 md:p-10 bg-gray-50">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                            Renueva ahora en 3 pasos
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Paso 1 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 bg-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">1</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Completa tus datos</h4>
                                    <p class="text-gray-600 text-sm mt-1">Solo necesitamos información básica</p>
                                </div>
                            </div>
                            
                            <!-- Paso 2 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 bg-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">2</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Sube los documentos</h4>
                                    <p class="text-gray-600 text-sm mt-1">Fotos nítidas desde tu celular</p>
                                </div>
                            </div>
                            
                            <!-- Paso 3 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 bg-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">3</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Pago seguro y envío</h4>
                                    <p class="text-gray-600 text-sm mt-1">Recibe tus documentos en 72 horas</p>
                                </div>
                            </div>
                            
                            <!-- Botón CTA -->
                            <button class="mt-8 w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z"/>
                                </svg>
                                INICIAR RENOVACIÓN
                            </button>
                            
                            <p class="text-center text-gray-500 text-xs mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Tus datos están protegidos con encriptación SSL
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== LINEA SEPARADORA ===== -->
    <div class="py-4 bg-gray-50"> 
        <div class="container mx-auto px-4">
            <div class="max-w-full mx-auto"> 
                <hr class="border-t-[1px] border-red-600 my-4">
            </div>
        </div>
    </div>

    <!-- ===== SECCIÓN ALERTAS ===== -->
    <section id="Alerta" class="py-16 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Contenedor principal centrado -->
            <div class="max-w-6xl mx-auto">
                
                <!-- Encabezado con icono animado -->
                <div class="text-center mb-12 md:mb-16">
                    <div class="inline-flex items-center justify-center bg-red-100 rounded-full w-16 h-16 sm:w-20 sm:h-20 mb-4 animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 font-bebas tracking-wide">
                        ALERTAS <span class="text-red-600">INTELIGENTES</span>
                    </h2>
                    <p class="text-gray-700 mt-4 text-base md:text-lg max-w-2xl mx-auto">
                        Nunca más olvides un mantenimiento o documento importante
                    </p>
                </div>

                <!-- Grid de alertas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Alerta 1 - SOAT -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-red-500">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Vencimiento SOAT</h3>
                                <p class="text-gray-600 mt-2 text-sm">Te avisamos 15 días antes para que renueves a tiempo</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-block bg-red-50 text-red-600 text-xs font-medium px-3 py-1 rounded-full">Documentación</span>
                        </div>
                    </div>
                    
                    <!-- Alerta 2 - Mantenimiento -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-orange-500">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-orange-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Mantenimientos</h3>
                                <p class="text-gray-600 mt-2 text-sm">Recordatorios para cambios de aceite, filtros y revisiones</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-block bg-orange-50 text-orange-600 text-xs font-medium px-3 py-1 rounded-full">Mecánica</span>
                        </div>
                    </div>
                    
                    <!-- Alerta 3 - Tecnomecánica -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-blue-500">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Tecnomecánica</h3>
                                <p class="text-gray-600 mt-2 text-sm">Alertas para no pasar la fecha límite de revisión</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-medium px-3 py-1 rounded-full">Documentación</span>
                        </div>
                    </div>
                    
                    <!-- Alerta 4 - Personalizadas -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Recordatorios</h3>
                                <p class="text-gray-600 mt-2 text-sm">Configura alertas personalizadas para tus necesidades</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-block bg-green-50 text-green-600 text-xs font-medium px-3 py-1 rounded-full">Personalizable</span>
                        </div>
                    </div>
                </div>

                <!-- CTA + Dispositivo móvil -->
                <div class="mt-16 bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Imagen móvil -->
                        <div class="lg:w-2/5 bg-gray-900 flex justify-center items-center p-8">
                            <div class="relative w-56 sm:w-64 md:w-72">
                                <!-- Asegúrate de que estas rutas de imagen sean correctas -->
                                <img src="<?= base_url('public/images/assets/mockup-alertas.png') ?>" alt="Alertas en la app" class="w-full h-auto">
                                <div class="absolute inset-0 flex items-center justify-center p-4">
                                    <img src="<?= base_url('public/images/assets/alertas-screen.png') ?>" alt="Pantalla de alertas" class="rounded-md w-full h-auto border border-gray-700">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Texto CTA -->
                        <div class="lg:w-3/5 p-8 md:p-10 flex flex-col justify-center">
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">¿Listo para mantener tu moto al día?</h3>
                            <p class="text-gray-600 mb-6 text-base md:text-lg">Activa las notificaciones y recibe recordatorios precisos directamente en tu celular</p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="#" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors flex items-center justify-center gap-2 text-base md:text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Activar alertas
                                </a>
                                <a href="#" class="flex-1 border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold py-3 px-6 rounded-lg text-center transition-colors text-base md:text-lg">
                                    Ver tutorial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sos -->
    <section id="sos" class="bg-gray-50 py-16 md:py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-red-600 mb-4">🚨 Sección SOS</h2>
            <p class="text-gray-700 mb-6 text-base md:text-lg">
                Si te encuentras varado o necesitas ayuda, esta sección está diseñada para brindarte la asistencia que necesitas.
            </p>

            <div class="grid gap-6 md:grid-cols-3">
                <!-- Información para desvararse -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-red-100">
                    <h3 class="text-xl font-semibold text-red-500 mb-2">Guía para desvararse</h3>
                    <p class="text-gray-600 text-sm">
                        Aprende qué pasos seguir si tu vehículo se queda detenido. Consejos útiles y seguros para resolverlo por ti mismo.
                    </p>
                    <a href="#guia-desvararse" class="text-red-500 hover:underline mt-2 inline-block text-sm">Ver guía</a>
                </div>

                <!-- Contacto con familiar -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-red-100">
                    <h3 class="text-xl font-semibold text-red-500 mb-2">Llamar a un familiar</h3>
                    <p class="text-gray-600 text-sm">
                        Puedes comunicarte rápidamente con un contacto de confianza para pedir ayuda o informar tu situación.
                    </p>
                    <a href="tel:+34123456789" class="text-red-500 hover:underline mt-2 inline-block text-sm">📞 Llamar ahora</a>
                </div>

                <!-- Técnico o asistencia -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-red-100">
                    <h3 class="text-xl font-semibold text-red-500 mb-2">Contactar asistencia</h3>
                    <p class="text-gray-600 text-sm">
                        Aquí puedes encontrar técnicos, grúas y otros servicios disponibles en tu zona.
                    </p>
                    <ul class="text-sm text-gray-600 mt-2 space-y-1">
                        <li><strong>Grúa 24h:</strong> <a href="tel:+34911222333" class="text-red-500 hover:underline">+34 911 222 333</a></li>
                        <li><strong>Asistencia mecánica:</strong> <a href="tel:+34911666777" class="text-red-500 hover:underline">+34 911 666 777</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-black text-gray-300 px-6 py-8 text-center text-sm">
        <p class="font-bold text-lg mb-2">RoarMot &copy; 2025</p>
        <p class="text-sm">"Motero ayuda a motero" - Todos los derechos reservados</p>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenuContent = document.getElementById('mobile-menu-content');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const closeMobileMenuButton = document.getElementById('close-mobile-menu');

        function toggleMobileMenu() {
            mobileMenuContent.classList.toggle('open');
            mobileMenuOverlay.style.display = mobileMenuContent.classList.contains('open') ? 'block' : 'none';
            document.body.classList.toggle('overflow-hidden'); // Evita el scroll del body cuando el menú está abierto
        }

        if (mobileMenuButton && mobileMenuContent && mobileMenuOverlay && closeMobileMenuButton) {
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
            closeMobileMenuButton.addEventListener('click', toggleMobileMenu);
            mobileMenuOverlay.addEventListener('click', toggleMobileMenu); // Cierra el menú al hacer clic en el overlay
        }

        // Smooth scroll for anchor links and close mobile menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
                
                // Close mobile menu if open after clicking an anchor link
                if (mobileMenuContent && mobileMenuContent.classList.contains('open')) {
                    toggleMobileMenu();
                }
            });
        });
    </script>
</body>
</html>