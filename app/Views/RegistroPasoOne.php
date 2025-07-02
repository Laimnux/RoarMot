<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Paso 1 | RoarMot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        .bg-cream { background-color: #FBF9F7; }
        .input-error { border-color: #ef4444 !important; }
        .error-message { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; }
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
        /* Estilos personalizados para el estado seleccionado */
        [selected] {
            background-color: #fd8c00 !important;
            color: white !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* Garantiza que el focus naranja tenga prioridad */
        .peer:focus {
            border-color: #fd8c00 !important;
        }
        /* Estilo para el autocompletado */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset;
        }
    </style>
</head>
<body class="bg-cream min-h-screen flex relative">

    <?php if (session()->getFlashdata('success')): ?>
        <div id="flash-success" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-green-600">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div id="flash-error" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full bg-red-600">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">

            <div class="bg-white p-4 rounded-xl shadow-sm mb-10">
                <div class="flex items-center justify-center space-x-1">
                    <img src="<?= base_url('public/images/assets/Logo-RoarMot-Negro.png') ?>" alt="Logo MYMOTO" class="h-16 w-auto object-contain">
                    <img src="<?= base_url('public/images/assets/tipografia-roarmot-negro.png') ?>" alt="Texto MYMOTO" class="h-10 w-auto object-contain">
                </div>
            </div>

            <div class="bg-white p-10 rounded-xl shadow-sm">
                <h1 class="font-bebas text-4xl text-gray-800 text-center mb-2">REGÍSTRATE Y EMPIEZA</h1>

                <form class="mt-8 space-y-6" id="formularioPaso1" action="<?= base_url('registro/paso1') ?>" method="POST">

                    <div class="relative mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona tu perfil</label>

                        <div class="flex border border-gray-300 rounded-lg overflow-hidden shadow-sm bg-gray-100 p-1">
                            <button
                                type="button"
                                id="motero-btn"
                                class="flex-1 py-3 px-4 text-center transition-all duration-300
                                       font-medium rounded-md
                                       bg-white text-gray-800
                                       hover:bg-gray-50 hover:shadow-sm"
                                onclick="selectRole('comprador')"
                                <?php if (old('rol') === 'comprador' || old('rol') === null): ?> selected="true" class="!bg-[#fd8c00] !text-white" <?php endif; ?>
                            >
                                Motero
                            </button>

                            <div class="w-px bg-gray-300 my-2"></div>

                            <button
                                type="button"
                                id="proveedor-btn"
                                class="flex-1 py-3 px-4 text-center transition-all duration-300
                                       font-medium rounded-md
                                       bg-white text-gray-800
                                       hover:bg-gray-50 hover:shadow-sm"
                                onclick="selectRole('vendedor')"
                                <?php if (old('rol') === 'vendedor'): ?> selected="true" class="!bg-[#fd8c00] !text-white" <?php endif; ?>
                            >
                                Vendedor
                            </button>
                        </div>

                        <input type="hidden" id="rol" name="rol" value="<?= old('rol') ?? 'comprador' ?>">
                        <div id="error-rol-server" class="error-message
                            <?php if (!isset($validation) || !$validation->hasError('rol')): ?> hidden <?php endif; ?>">
                            <?= (isset($validation) && $validation->hasError('rol')) ? $validation->getError('rol') : '' ?>
                        </div>
                        <div id="error-rol-client" class="error-message hidden"></div> </div>

                    <div class="relative mb-6">
                        <input
                            type="email"
                            id="email"
                            name="email" required
                            class="peer w-full px-3 border rounded-md bg-transparent
                                   border-gray-300
                                   focus:border-[#fd8c00] focus:outline-none
                                   placeholder-shown:border-gray-300
                                   <?php if (isset($validation) && $validation->hasError('email')): ?> border-red-500 shake <?php endif; ?>"
                            placeholder=" "
                            style="padding-top: 1rem; padding-bottom: 0.85rem;"
                            value="<?= old('email') ?>" />

                        <label
                            for="email"
                            class="absolute left-3 bg-white px-1
                                   transition-all duration-200 pointer-events-none
                                   text-gray-500
                                   peer-placeholder-shown:text-base
                                   peer-placeholder-shown:top-[1.1rem]
                                   peer-placeholder-shown:-translate-y-0
                                   peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                   peer-valid:top-[-0.5rem] peer-valid:text-xs peer-valid:text-green-600
                                   <?php if (isset($validation) && $validation->hasError('email')): ?> !text-red-500 <?php endif; ?>"
                        >
                            Correo Electrónico
                        </label>

                        <div id="error-email-client" class="error-message text-xs mt-1
                            <?php if (!isset($validation) || !$validation->hasError('email')): ?> hidden <?php endif; ?>">
                            <?= (isset($validation) && $validation->hasError('email')) ? $validation->getError('email') : 'Ingresa un email válido (ejemplo@dominio.com).' ?>
                        </div>
                    </div>

                    <button type="submit"
                            id="continueButton"
                            class="w-full bg-red-600 hover:bg-[#fd8c00] text-white
                                   py-4 px-6 rounded-md font-bebas text-2xl
                                   transition-all duration-300 transform hover:scale-[1.02]
                                   shadow-lg hover:shadow-xl mt-6">
                        Continuar
                    </button>

                    <div class="relative flex items-center py-2">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink mx-4 font-bebas text-gray-400">O</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div id="motero-options" class="mt-6 text-center space-y-4">
                        <a href="#" class="flex items-center justify-center border border-gray-300 rounded-md py-3 px-4 hover:bg-gray-50 transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
                                 alt="Google" class="h-5 w-5 mr-2">
                            <span class="text-gray-700 font-medium">Iniciar sesión con Google</span>
                        </a>

                        <p class="text-gray-600 text-sm">
                            ¿Ya tienes una cuenta?
                            <a href="<?= base_url('iniciarSesion') ?>" class="text-[#fd8c00] hover:underline">Inicia sesión</a>
                        </p>
                    </div>

                    <div id="proveedor-options" class="hidden mt-6 text-center">
                        <p class="text-gray-600 text-sm">
                            Para tiendas registradas:
                            <a href="<?= base_url('iniciarSesion') ?>" class="text-[#fd8c00] hover:underline">Acceso especial</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 relative">
        <div class="absolute inset-0 flex items-center justify-center p-2">
            <div class="relative w-full h-full rounded-xl overflow-hidden shadow-lg">
                <img id="dynamic-image" src="<?= base_url('public/images/assets/Motero.jpg') ?>" alt="Moto MYMOTO"
                     class="absolute h-full w-auto max-w-none left-[-15%] transition-all duration-300">

                <img id="proveedor-image" src="<?= base_url('public/images/assets/proveedor.jpg') ?>" alt="Proveedor MYMOTO"
                     class="absolute h-full w-auto max-w-none right-[-40%] opacity-0 transition-all duration-300">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rolInput = document.getElementById('rol');
            const moteroBtn = document.getElementById('motero-btn');
            const proveedorBtn = document.getElementById('proveedor-btn');
            const emailInput = document.getElementById('email');
            const continueButton = document.getElementById('continueButton');
            const form = document.getElementById('formularioPaso1');

            // Función para mostrar mensajes flash de CodeIgniter
            function showAlert(message, type) {
                const alertaDiv = document.getElementById('flash-' + type); // Usamos los IDs que ya tenemos
                if (alertaDiv) {
                    alertaDiv.classList.remove('hidden');
                    setTimeout(() => {
                        alertaDiv.classList.add('hidden');
                        alertaDiv.remove(); // Opcional: Eliminar el elemento después de mostrar
                    }, 3000);
                }
            }

            // Llamar a showAlert para los mensajes flash existentes
            <?php if (session()->getFlashdata('success')): ?>
                showAlert('<?= session()->getFlashdata('success') ?>', 'success');
            <?php elseif (session()->getFlashdata('error')): ?>
                showAlert('<?= session()->getFlashdata('error') ?>', 'error');
            <?php endif; ?>

            // *** FUNCIONES JS ORIGINALES, ADAPTADAS ***
            function selectRole(role) {
                const moteroImage = document.getElementById('dynamic-image');
                const proveedorImage = document.getElementById('proveedor-image');
                const moteroOptions = document.getElementById('motero-options');
                const proveedorOptions = document.getElementById('proveedor-options');

                rolInput.value = role; // Actualiza el input oculto

                // Resetear y aplicar estilos a los botones
                moteroBtn.classList.remove('!bg-[#fd8c00]', '!text-white');
                proveedorBtn.classList.remove('!bg-[#fd8c00]', '!text-white');
                moteroBtn.removeAttribute('selected');
                proveedorBtn.removeAttribute('selected');

                if (role === 'comprador') {
                    moteroBtn.classList.add('!bg-[#fd8c00]', '!text-white');
                    moteroBtn.setAttribute('selected', 'true');
                    moteroImage.classList.remove('opacity-0');
                    moteroImage.classList.add('left-[-15%]');
                    proveedorImage.classList.add('opacity-0');
                    proveedorImage.classList.remove('right-[-40%]');
                    moteroOptions.classList.remove('hidden');
                    proveedorOptions.classList.add('hidden');
                } else { // 'vendedor'
                    proveedorBtn.classList.add('!bg-[#fd8c00]', '!text-white');
                    proveedorBtn.setAttribute('selected', 'true');
                    moteroImage.classList.add('opacity-0');
                    moteroImage.classList.remove('left-[-15%]');
                    proveedorImage.classList.remove('opacity-0');
                    proveedorImage.classList.add('right-[-40%]');
                    moteroOptions.classList.add('hidden');
                    proveedorOptions.classList.remove('hidden');
                }
                validateForm(); // Re-validar al cambiar el rol
            }

            function validateEmailInput() {
                const errorElement = document.getElementById('error-email-client');
                const emailValue = emailInput.value.trim();
                const isValidFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

                emailInput.classList.remove('shake', 'border-red-500', 'border-green-500', 'border-gray-300');
                errorElement.classList.add('hidden');

                if (emailValue === '') {
                    emailInput.classList.add('border-gray-300');
                    // Restablecer label a estado inicial si input está vacío
                    emailInput.previousElementSibling.classList.remove('!text-red-500', '!text-green-600', 'top-[-0.5rem]', 'text-xs');
                    emailInput.previousElementSibling.classList.add('text-gray-500', 'top-[1.1rem]', 'text-base');
                } else if (!isValidFormat) {
                    emailInput.classList.add('border-red-500', 'shake');
                    errorElement.textContent = 'Ingresa un email válido (ejemplo@dominio.com).';
                    errorElement.classList.remove('hidden');
                    emailInput.previousElementSibling.classList.add('!text-red-500'); // Label también en rojo
                    emailInput.previousElementSibling.classList.remove('text-gray-500', 'top-[1.1rem]', 'text-base');
                    emailInput.previousElementSibling.classList.add('top-[-0.5rem]', 'text-xs');
                } else {
                    emailInput.classList.add('border-green-500'); // Opcional: borde verde cuando es válido
                    emailInput.previousElementSibling.classList.remove('!text-red-500', 'text-gray-500');
                    emailInput.previousElementSibling.classList.add('!text-green-600', 'top-[-0.5rem]', 'text-xs');
                }
                validateForm();
            }

            function validateForm() {
                const isEmailValid = emailInput.value.trim() !== '' && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
                const isRolSelected = rolInput.value !== ''; // Siempre tendrá un valor por defecto

                if (isEmailValid && isRolSelected) {
                    continueButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    continueButton.disabled = false;
                } else {
                    continueButton.classList.add('opacity-50', 'cursor-not-allowed');
                    continueButton.disabled = true;
                }
            }

            // Event Listeners
            emailInput.addEventListener('input', validateEmailInput);
            emailInput.addEventListener('blur', validateEmailInput); // Re-validar al salir del campo
            emailInput.addEventListener('focus', function() {
                emailInput.classList.remove('shake', 'border-red-500', 'border-green-500', 'border-gray-300');
                emailInput.classList.add('border-[#fd8c00]');
                emailInput.previousElementSibling.classList.remove('!text-red-500', 'text-gray-500', '!text-green-600', 'top-[1.1rem]', 'text-base');
                emailInput.previousElementSibling.classList.add('text-[#fd8c00]', 'top-[-0.5rem]', 'text-xs');
                document.getElementById('error-email-client').classList.add('hidden');
            });


            // Manejo del envío del formulario (para la carga y deshabilitación)
            form.addEventListener('submit', function(event) {
                // Ejecutar validación final antes de enviar
                validateEmailInput(); // Asegura que las validaciones cliente se ejecuten
                
                // Si el botón está deshabilitado por JS, prevenimos el envío
                if (continueButton.disabled) {
                    event.preventDefault();
                    // Asegúrate de que los mensajes de error del cliente sean visibles si la validación falla
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                        document.getElementById('error-email-client').classList.remove('hidden');
                    }
                    if (!rolInput.value) { // Aunque rol siempre tendrá valor, por si acaso
                         document.getElementById('error-rol-client').classList.remove('hidden');
                         document.getElementById('error-rol-client').textContent = 'Selecciona un rol';
                    }
                    return; // Detiene el envío
                }

                const textoOriginal = continueButton.textContent;
                continueButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                `;
                continueButton.disabled = true;

                // ELIMINAMOS la redirección setTimeout del JavaScript,
                // ahora el servidor (CodeIgniter) se encargará de la redirección.
                // try {
                //   await new Promise(resolve => setTimeout(resolve, 1500));
                //   // No hay redirección JS aquí, el form se envía al action
                // } catch (error) {
                //   // ... (manejo de errores de simulación, ya no es necesario si el servidor responde)
                // }
            });

            // Inicialización al cargar la página
            selectRole(rolInput.value || 'comprador'); // Asegura que el botón correcto esté seleccionado inicialmente
            validateEmailInput(); // Validar estado inicial del email (si viene de old())
            validateForm(); // Habilitar/deshabilitar botón al inicio
        });
    </script>
</body>
</html>