<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | MYMOTO</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <style>
        /* Clase para aplicar la fuente Bebas Neue */
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }

        /* Color de fondo personalizado */
        .bg-cream { background-color: #FBF9F7; }

        /* Animación de vibración para inputs con error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        /* Clase para aplicar la animación shake */
        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }
    </style>
</head>
<body class="bg-cream min-h-screen flex relative">
    <div id="alerta-servidor" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full">
        <span id="mensaje-alerta-servidor"></span>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div id="flash-success" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-green-600">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div id="flash-error" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-red-600">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>


    <div class="hidden lg:block w-1/2 relative overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center">
            <img src="<?= base_url('public/images/assets/imgRegistro.jpg') ?>" alt="Moto MYMOTO"
                 class="h-full w-full object-[1%_40%] object-cover">
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">

            <div class="bg-white p-4 rounded-xl shadow-sm mb-10">
                <div class="flex items-center justify-center space-x-1">
                    <img src="<?= base_url('public/images/assets/Logo-RoarMot-Negro.png') ?>" alt="Logo MYMOTO" class="h-16 w-auto object-contain">
                    <img src="<?= base_url('public/images/assets/tipografia-roarmot-negro.png') ?>" alt="Texto MYMOTO" class="h-10 w-auto object-contain">
                </div>
            </div>

            <div class="bg-white p-10 rounded-xl shadow-sm">
                <h1 class="font-bebas text-4xl text-gray-800 text-center mb-2">INICIA SESIÓN</h1>

                <form class="mt-8 space-y-6" id="loginForm" action="<?= base_url('auth/loginProcess') ?>" method="POST">
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email" required
                            autocomplete="email"
                            placeholder=" "
                            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                            data-error-msg="Por favor, ingresa un correo electrónico válido (ejemplo@dominio.com)"
                            value="<?= old('email') ?>" class="form-input peer w-full px-4 pt-4 pb-4 border rounded-md
                                   border-gray-300 bg-white focus:outline-none focus:border-[#fd8c00] placeholder-transparent
                                   transition-colors duration-200
                                   <?php if (isset($validation) && $validation->hasError('email')): ?> border-red-500 shake <?php endif; ?>"
                        />
                        <label
                            for="email"
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-base text-gray-500 bg-white px-1
                                   transition-all duration-200 pointer-events-none
                                   peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base
                                   peer-placeholder-shown:text-gray-400
                                   peer-focus:top-[-0.50rem] peer-focus:-translate-y-0 peer-focus:text-sm peer-focus:text-[#fd8c00]
                                   peer-valid:top-[-0.50rem] peer-valid:-translate-y-0 peer-valid:text-sm
                                   <?php if (isset($validation) && $validation->hasError('email')): ?> text-red-500 <?php endif; ?>" >
                            Correo electrónico
                        </label>
                        <div class="error-message mt-1 text-red-500 text-xs
                             <?php if (!isset($validation) || !$validation->hasError('email')): ?> hidden <?php endif; ?>">
                            <?= (isset($validation) && $validation->hasError('email')) ? $validation->getError('email') : '' ?>
                        </div>
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="contrasena" required
                            placeholder=" "
                            minlength="8"
                            data-error-msg="La contraseña debe tener al menos 8 caracteres."
                            class="form-input peer w-full px-4 pt-4 pb-4 border rounded-md
                                   border-gray-300 bg-white focus:outline-none focus:border-[#fd8c00] placeholder-transparent
                                   transition-colors duration-200
                                   <?php if (isset($validation) && $validation->hasError('contrasena')): ?> border-red-500 shake <?php endif; ?>"
                        />
                        <label
                            for="password"
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-base text-gray-500 bg-white px-1
                                   transition-all duration-200 pointer-events-none
                                   peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base
                                   peer-placeholder-shown:text-gray-400
                                   peer-focus:top-[-0.50rem] peer-focus:-translate-y-0 peer-focus:text-sm peer-focus:text-[#fd8c00]
                                   peer-valid:top-[-0.50rem] peer-valid:-translate-y-0 peer-valid:text-sm
                                   <?php if (isset($validation) && $validation->hasError('contrasena')): ?> text-red-500 <?php endif; ?>" >
                            Contraseña
                        </label>
                        <div class="error-message mt-1 text-red-500 text-xs
                             <?php if (!isset($validation) || !$validation->hasError('contrasena')): ?> hidden <?php endif; ?>">
                            <?= (isset($validation) && $validation->hasError('contrasena')) ? $validation->getError('contrasena') : '' ?>
                        </div>
                    </div>

                    <button type="submit"
                            id="loginButton"
                            class="w-full bg-gray-400 text-white
                                   opacity-50 cursor-not-allowed
                                   py-4 px-6 rounded-md font-bebas text-2xl
                                   transition-all duration-300 transform shadow-lg">
                        INGRESAR
                    </button>
                </form>

                <div class="relative flex items-center py-6">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 font-bebas text-gray-400">O</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div class="text-center">
                    <p class="font-bebas text-xl text-gray-600">¿No tienes cuenta?</p>
                    <a href="<?= base_url('registro') ?>"
                       class="inline-block font-bebas text-xl text-red-600 hover:text-[#fd8c00] mt-2
                              transition-colors duration-300">
                        Crear Cuenta
                    </a>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="mt-4 text-xl italic font-bold text-transparent bg-clip-text
                bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600
                relative inline-block group cursor-pointer mx-auto text-center">
                "MOTERO AYUDA MOTERO"
                <span class="absolute left-0 bottom-0 h-[3px] w-0 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600
                              transition-all duration-500 ease-out group-hover:w-full">
                </span>
                </p>

                <div class="mt-12 text-center">
                    <p class="text-sm text-gray-500">Español - Latinoamérica</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');
        const form = document.getElementById('loginForm');
        const inputs = document.querySelectorAll('.form-input');

        // Función para mostrar mensajes de alerta (para los mensajes flash de CI)
        function showAlert(message, type) {
            const alertaDiv = document.getElementById('alerta-servidor');
            const mensajeSpan = document.getElementById('mensaje-alerta-servidor');
            alertaDiv.classList.remove('hidden', 'bg-green-600', 'bg-red-600');
            
            mensajeSpan.textContent = message;
            if (type === 'success') {
                alertaDiv.classList.add('bg-green-600');
            } else if (type === 'error') {
                alertaDiv.classList.add('bg-red-600');
            } else {
                alertaDiv.classList.add('bg-gray-700'); // Default
            }
            alertaDiv.classList.remove('hidden');

            setTimeout(() => {
                alertaDiv.classList.add('hidden');
            }, 3000); // Ocultar después de 3 segundos
        }

        // Cargar y mostrar mensajes flash existentes al cargar la página
        const flashSuccess = document.getElementById('flash-success');
        if (flashSuccess) {
            showAlert(flashSuccess.textContent.trim(), 'success');
            flashSuccess.remove(); // Eliminar el div para evitar duplicados visuales
        }
        const flashError = document.getElementById('flash-error');
        if (flashError) {
            showAlert(flashError.textContent.trim(), 'error');
            flashError.remove(); // Eliminar el div
        }


        function updateLoginButtonState() {
            const isEmailValid = emailInput.checkValidity() && emailInput.value.trim() !== '';
            const isPasswordValid = passwordInput.checkValidity() && passwordInput.value.trim() !== '';

            if (isEmailValid && isPasswordValid) {
                loginButton.classList.remove('bg-gray-400', 'opacity-50', 'cursor-not-allowed');
                loginButton.classList.add('bg-red-600', 'hover:bg-[#fd8c00]', 'hover:scale-[1.02]', 'hover:shadow-xl');
                loginButton.disabled = false;
            } else {
                loginButton.classList.remove('bg-red-600', 'hover:bg-[#fd8c00]', 'hover:scale-[1.02]', 'hover:shadow-xl');
                loginButton.classList.add('bg-gray-400', 'opacity-50', 'cursor-not-allowed');
                loginButton.disabled = true;
            }
        }

        inputs.forEach(input => {
            const parentDiv = input.closest('.relative');
            const label = parentDiv.querySelector('label');
            const errorMessageDiv = parentDiv.querySelector('.error-message');
            const originalErrorMsg = input.dataset.errorMsg;

            function applyValidationStyles() {
                input.classList.remove('border-red-500', 'border-green-500', 'shake');
                label.classList.remove('text-red-500', 'text-green-500');
                errorMessageDiv.classList.add('hidden');
                errorMessageDiv.textContent = '';

                if (input.value.trim() === '') {
                    input.classList.add('border-gray-300');
                    label.classList.remove('top-[-0.50rem]', 'text-sm');
                    label.classList.add('top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                } else if (input.checkValidity()) {
                    input.classList.add('border-green-500');
                    label.classList.add('text-green-500');
                    label.classList.remove('top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                    label.classList.add('top-[-0.50rem]', 'text-sm');
                } else {
                    input.classList.add('border-red-500', 'shake');
                    label.classList.add('text-red-500');
                    errorMessageDiv.textContent = originalErrorMsg;
                    errorMessageDiv.classList.remove('hidden');
                    label.classList.remove('top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                    label.classList.add('top-[-0.50rem]', 'text-sm');
                }
                updateLoginButtonState();
            }

            input.addEventListener('input', function() {
                applyValidationStyles();
                if (input.checkValidity() && input.value.trim() !== '') {
                    input.classList.add('border-[#fd8c00]');
                    label.classList.add('text-[#fd8c00]');
                }
            });

            input.addEventListener('focus', function() {
                input.classList.remove('border-gray-300', 'border-red-500', 'border-green-500');
                input.classList.add('border-[#fd8c00]');
                
                label.classList.remove('text-gray-500', 'text-red-500', 'text-green-500', 'top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                label.classList.add('text-[#fd8c00]', 'top-[-0.50rem]', 'text-sm');
                
                errorMessageDiv.classList.add('hidden');
                input.classList.remove('shake');
            });

            input.addEventListener('blur', function() {
                if (input.value.trim() !== '' || !input.checkValidity()) {
                    applyValidationStyles();
                } else {
                    input.classList.remove('border-red-500', 'border-green-500', 'border-[#fd8c00]');
                    input.classList.add('border-gray-300');
                    label.classList.remove('text-red-500', 'text-green-500', 'text-[#fd8c00]', 'top-[-0.50rem]', 'text-sm');
                    label.classList.add('text-gray-500', 'top-1/2', '-translate-y-1/2', 'text-base');
                    errorMessageDiv.classList.add('hidden');
                }
                updateLoginButtonState();
            });

            if (input.value.trim() !== '') {
                input.classList.remove('border-gray-300');
                label.classList.remove('top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                label.classList.add('top-[-0.50rem]', 'text-sm');

                if (input.checkValidity()) {
                    input.classList.add('border-green-500');
                    label.classList.add('text-green-500');
                } else {
                    input.classList.add('border-red-500');
                    label.classList.add('text-red-500');
                    errorMessageDiv.textContent = originalErrorMsg;
                    errorMessageDiv.classList.remove('hidden');
                }
            }
        });

        form.addEventListener('submit', function(event) {
            if (loginButton.disabled) {
                event.preventDefault();
                inputs.forEach(input => {
                    const parentDiv = input.closest('.relative');
                    const errorMessageDiv = parentDiv.querySelector('.error-message');
                    const label = parentDiv.querySelector('label');

                    if (!input.checkValidity() || input.value.trim() === '') {
                        input.classList.add('border-red-500', 'shake');
                        label.classList.add('text-red-500');
                        errorMessageDiv.textContent = input.dataset.errorMsg;
                        errorMessageDiv.classList.remove('hidden');
                        label.classList.remove('top-1/2', '-translate-y-1/2', 'text-base', 'text-gray-400');
                        label.classList.add('top-[-0.50rem]', 'text-sm');
                    }
                });
                return;
            }
            // Aquí el formulario se enviará al servidor a la acción definida en <form action="...">
            // Por lo tanto, el setTimeout y la redirección JS ya no son necesarios
            // setTimeout(() => { window.location.href = 'dashboard.html'; }, 2000); // ELIMINAR ESTO
        });

        updateLoginButtonState();
    });
    </script>
</body>
</html>