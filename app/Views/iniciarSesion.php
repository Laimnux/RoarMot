<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión | MYMOTO</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <style>
    .font-bebas { font-family: 'Bebas Neue', sans-serif; }
    .bg-cream { background-color: #FBF9F7; }
  </style>
</head>
<body class="bg-cream min-h-screen flex relative">

  <!-- Alerta emergente -->
  <div id="alerta" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full">
    <span id="mensaje-alerta"></span>
  </div>

  <!-- Columna izquierda - Imagen -->
  <div class="hidden lg:block w-1/2 relative overflow-hidden">
    <div class="absolute inset-0 flex items-center justify-center">
      <img src="public/images/assets/imgRegistro.jpg" alt="Moto MMOTO" 
           class="h-full w-full object-[1%_40%] object-cover">
    </div>
  </div>

  <!-- Columna derecha - Formulario -->
  <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
    <div class="max-w-md w-full">
      
      <!-- Logo -->
      <div class="bg-white p-4 rounded-xl shadow-sm mb-10">
        <div class="flex items-center justify-center space-x-1">
          <img src="public/images/assets/Logo-RoarMot-Negro.png" alt="Logo MMOTO" class="h-16 w-auto object-contain">
          <img src="public/images/assets/tipografia-roarmot-negro.png" alt="Texto MMOTO" class="h-10 w-auto object-contain">
        </div>
      </div>

      <!-- Formulario -->
      <div class="bg-white p-10 rounded-xl shadow-sm">
        <h1 class="font-bebas text-4xl text-gray-800 text-center mb-2">INICIA SESIÓN</h1>
        
        <form class="mt-8 space-y-6">

          <!-- Email -->
          <div class="relative">
            <input 
              type="email" 
              id="email" 
              required 
              autocomplete="email"
              placeholder="Ingresa tu correo"
              class="peer w-full px-4 pt-6 pb-2 border border-gray-200 rounded-md
                     bg-gray-50 focus:outline-none focus:border-[#fd8c00] placeholder-transparent"
            />
            <label 
              for="email"
              class="absolute left-4 top-2.5 text-sm text-gray-500 bg-gray-50 px-1 
                     transition-all duration-200 pointer-events-none 
                     peer-placeholder-shown:top-4 peer-placeholder-shown:text-base 
                     peer-placeholder-shown:text-gray-400 
                     peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-[#fd8c00]">
              Ingrese su correo
            </label>
          </div>

          <!-- Contraseña -->
          <div class="relative">
            <input 
              type="password" 
              id="password" 
              required 
              placeholder="Ingresa tu contraseña"
              class="peer w-full px-4 pt-6 pb-2 border border-gray-200 rounded-md
                     bg-gray-50 focus:outline-none focus:border-[#fd8c00] placeholder-transparent"
            />
            <label 
              for="password"
              class="absolute left-4 top-2.5 text-sm text-gray-500 bg-gray-50 px-1 
                     transition-all duration-200 pointer-events-none 
                     peer-placeholder-shown:top-4 peer-placeholder-shown:text-base 
                     peer-placeholder-shown:text-gray-400 
                     peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-[#fd8c00]">
              Contraseña
            </label>
          </div>

          <!-- Botón -->
          <button type="submit" 
                  class="w-full bg-red-600 hover:bg-[#fd8c00] text-white 
                         py-4 px-6 rounded-md font-bebas text-2xl 
                         transition-all duration-300 transform hover:scale-[1.02]
                         shadow-lg hover:shadow-xl mt-4">
            INGRESAR
          </button>

        </form>

        <!-- Separador -->
        <div class="relative flex items-center py-6">
          <div class="flex-grow border-t border-gray-200"></div>
          <span class="flex-shrink mx-4 font-bebas text-gray-400">O</span>
          <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- Registro -->
        <div class="text-center">
          <p class="font-bebas text-xl text-gray-600">¿No tienes cuenta?</p>
          <a href="registro.html" 
             class="inline-block font-bebas text-xl text-red-600 hover:text-[#fd8c00] mt-2
                    transition-colors duration-300">
            Crear Cuenta
          </a>
        </div>
      </div>

      <!-- Frase con degradado y subrayado animado -->
      <div class="mt-12 text-center">
        <p class="mt-4 text-xl italic font-bold text-transparent bg-clip-text 
        bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600 
        relative inline-block group cursor-pointer mx-auto text-center">
        "MOTERO AYUDA MOTERO"
        <span class="absolute left-0 bottom-0 h-[3px] w-0 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600 
            transition-all duration-500 ease-out group-hover:w-full">
        </span>
        </p>

        <!-- Footer inferior -->
        <div class="mt-12 text-center">
          <p class="text-sm text-gray-500">Español - Latinoamérica</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Script de validación con alerta emergente -->
  <script>
    document.querySelector('form').addEventListener('submit', function(event) {
      event.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const alerta = document.getElementById('alerta');
      const mensaje = document.getElementById('mensaje-alerta');

      const validEmail = 'yeferson232@gmail.com';
      const validPassword = '00000';
      

      if (email === validEmail && password === validPassword) {
        mensaje.textContent = 'Inicio de sesión exitoso.';
        alerta.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-green-600';
      } else {
        mensaje.textContent = 'Usuario no registrado';
        alerta.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-red-600';
      }

      alerta.classList.remove('hidden');

      setTimeout(() => {
        alerta.classList.add('hidden');
      }, 3000); // Oculta después de 3 segundos
    });
  </script>
</body>
</html>