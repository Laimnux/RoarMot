<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil | RoarMot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        /* Clase para usar la fuente Bebas Neue */
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        /* Color de fondo personalizado */
        .bg-cream { background-color: #FBF9F7; }
        
        /* Estilos para los inputs cuando tienen focus */
        .peer:focus {
            border-color: #fd8c00 !important; /* Color naranja del borde al enfocar */
        }
        .peer-focus:text-[#fd8c00] { /* Color del label al enfocar */
            color: #fd8c00 !important;
        }

        /* Estilos para inputs válidos e inválidos */
        .form-input.valid { border-color: #22c55e !important; } /* verde */
        .form-input.invalid { border-color: #ef4444 !important; } /* rojo */

        /* Estilos para los labels cuando el input es válido/inválido */
        .form-input.valid ~ label { color: #22c55e !important; }
        .form-input.invalid ~ label { color: #ef4444 !important; }
        
        /* Estilo para los mensajes de error */
        .error-message { 
            color: #ef4444; /* rojo */
            font-size: 0.75rem; /* pequeño */
            margin-top: 0.25rem; 
        }
        
        /* Animación de shake para inputs inválidos */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .shake { animation: shake 0.5s; }
        
        /* Estilos para la barra de fortaleza de contraseña */
        #password-strength-bar {
            height: 6px;
            width: 100%;
            background-color: #e2e8f0; /* gris claro */
            border-radius: 9999px; /* completamente redondeado */
            overflow: hidden;
            margin-top: 0.5rem;
            display: flex; /* los segmentos se alinean en línea */
        }
        #password-strength-bar span {
            flex-grow: 1; /* los segmentos ocupan espacio igual */
            transition: background-color 0.3s ease-in-out;
            height: 100%;
        }

        /* Estilo para el botón cuando está deshabilitado */
        #submit-btn:disabled {
            background-color: #a0aec0 !important; /* gris */
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
            opacity: 0.7; /* semi-transparente */
        }

        /* Estilo para el icono de mostrar/ocultar contraseña */
        .password-toggle-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af; /* gris */
            z-index: 10; /* sobre el input */
        }
        .password-toggle-icon svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body class="bg-cream min-h-screen flex relative">

    <div id="alerta" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full">
        <span id="mensaje-alerta"></span>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">
            
            <div class="bg-white p-4 rounded-xl shadow-sm mb-10">
                <div class="flex items-center justify-center space-x-1">
                    <img src="<?= base_url('public/images/assets/Logo-RoarMot-Negro.png') ?>" alt="Logo RoarMot" class="h-16 w-auto object-contain">
                    <img src="<?= base_url('public/images/assets/tipografia-roarmot-negro.png') ?>" alt="Texto RoarMot" class="h-10 w-auto object-contain">
                </div>
            </div>

            <div class="bg-white p-10 rounded-xl shadow-sm">
                <h1 class="font-bebas text-4xl text-gray-800 text-center mb-2">COMPLETA TU PERFIL</h1>
                <p class="text-gray-600 text-center mb-8">Último paso para unirte a la comunidad como <span class="font-semibold text-[#fd8c00]">
                    <?php
                        if ($rol === 'comprador') {
                            echo 'Motero';
                        } else {
                            echo esc($rol); // Mantener el rol original para otros casos
                        }
                    ?>
                </span></p>
                
                <?php if (isset($validation)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">¡Error de validación!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            <?php foreach ($validation->getErrors() as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form class="mt-8 space-y-6" id="formularioPaso3" action="<?= base_url('registro/completar') ?>" method="post">
                    
                    <!-- Campos ocultos para email y rol (CRUCIALES) -->
                    <input type="hidden" id="email" name="email" value="<?= esc($email ?? '') ?>">
                    <input type="hidden" id="rol" name="rol" value="<?= esc($rol ?? '') ?>">

                    <div class="space-y-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="relative flex-1">
                                <input 
                                    type="text" 
                                    id="nombre" 
                                    name="nombre"
                                    required 
                                    maxlength="30"
                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                                    data-error-msg="Solo se permiten letras (máx. 30)."
                                    class="form-input peer w-full px-3 border rounded-md bg-transparent
                                            border-gray-300 focus:outline-none <?= isset($validation) && $validation->hasError('nombre') ? 'invalid' : '' ?>"
                                    placeholder=" "
                                    value="<?= old('nombre') ?>"
                                    style="padding-top: 1rem; padding-bottom: 0.85rem;"
                                />
                                <label 
                                    for="nombre"
                                    class="absolute left-3 bg-white px-1
                                            transition-all duration-200 pointer-events-none
                                            text-gray-500
                                            peer-placeholder-shown:text-base
                                            peer-placeholder-shown:top-[1.1rem]
                                            peer-placeholder-shown:-translate-y-0
                                            peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                            peer-valid:top-[-0.5rem] peer-valid:text-xs peer-valid:text-green-600
                                            <?= isset($validation) && $validation->hasError('nombre') ? 'text-red-500' : '' ?>" 
                                >
                                    Nombre
                                </label>
                                <div class="error-message <?= isset($validation) && $validation->hasError('nombre') ? '' : 'hidden' ?>">
                                    <?= isset($validation) ? $validation->getError('nombre') : '' ?>
                                </div>
                            </div>

                            <div class="relative flex-1">
                                <input 
                                    type="text" 
                                    id="apellido" 
                                    name="apellido"
                                    required 
                                    maxlength="30"
                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                                    data-error-msg="Solo se permiten letras (máx. 30)."
                                    class="form-input peer w-full px-3 border rounded-md bg-transparent
                                            border-gray-300 focus:outline-none <?= isset($validation) && $validation->hasError('apellido') ? 'invalid' : '' ?>"
                                    placeholder=" "
                                    value="<?= old('apellido') ?>"
                                    style="padding-top: 1rem; padding-bottom: 0.85rem;"
                                >
                                <label 
                                    for="apellido"
                                    class="absolute left-3 bg-white px-1
                                            transition-all duration-200 pointer-events-none
                                            text-gray-500
                                            peer-placeholder-shown:text-base
                                            peer-placeholder-shown:top-[1.1rem]
                                            peer-placeholder-shown:-translate-y-0
                                            peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                            peer-valid:top-[-0.5rem] peer-valid:text-xs peer-valid:text-green-600
                                            <?= isset($validation) && $validation->hasError('apellido') ? 'text-red-500' : '' ?>" 
                                >
                                    Apellido
                                </label>
                                <div class="error-message <?= isset($validation) && $validation->hasError('apellido') ? '' : 'hidden' ?>">
                                    <?= isset($validation) ? $validation->getError('apellido') : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <input 
                                type="tel" 
                                id="telefono" 
                                name="telefono"
                                required 
                                maxlength="10"
                                pattern="\d{10}"
                                data-error-msg="Ingresa un teléfono válido (10 dígitos)."
                                class="form-input peer w-full px-3 border rounded-md bg-transparent
                                        border-gray-300 focus:outline-none <?= isset($validation) && $validation->hasError('telefono') ? 'invalid' : '' ?>"
                                placeholder=" "
                                value="<?= old('telefono') ?>"
                                style="padding-top: 1rem; padding-bottom: 0.85rem;"
                            >
                            <label 
                                for="telefono"
                                class="absolute left-3 bg-white px-1
                                        transition-all duration-200 pointer-events-none
                                        text-gray-500
                                        peer-placeholder-shown:text-base
                                        peer-placeholder-shown:top-[1.1rem]
                                        peer-placeholder-shown:-translate-y-0
                                        peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                        <?= isset($validation) && $validation->hasError('telefono') ? 'text-red-500' : '' ?>" 
                            >
                                Teléfono
                            </label>
                            <div class="error-message <?= isset($validation) && $validation->hasError('telefono') ? '' : 'hidden' ?>">
                                <?= isset($validation) ? $validation->getError('telefono') : '' ?>
                            </div>
                        </div>

                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                required 
                                minlength="8"
                                class="form-input peer w-full px-3 border rounded-md bg-transparent
                                        border-gray-300 focus:outline-none pr-10 <?= isset($validation) && $validation->hasError('password') ? 'invalid' : '' ?>"
                                placeholder=" "
                                style="padding-top: 1rem; padding-bottom: 0.85rem;"
                            >
                            <label 
                                for="password"
                                class="absolute left-3 bg-white px-1
                                        transition-all duration-200 pointer-events-none
                                        text-gray-500
                                        peer-placeholder-shown:text-base
                                        peer-placeholder-shown:top-[1.1rem]
                                        peer-placeholder-shown:-translate-y-0
                                        peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                        <?= isset($validation) && $validation->hasError('password') ? 'text-red-500' : '' ?>" 
                            >
                                Contraseña (mínimo 8 caracteres)
                            </label>
                            <span class="password-toggle-icon" onclick="togglePasswordVisibility('password')">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path id="password-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="password-icon-path2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </span>
                            <div class="error-message <?= isset($validation) && $validation->hasError('password') ? '' : 'hidden' ?>">
                                <?= isset($validation) ? $validation->getError('password') : '' ?>
                            </div>
                            
                            <div id="password-strength-bar" class="w-full mt-2 hidden">
                                <span id="strength-segment-1" class="rounded-l-full"></span>
                                <span id="strength-segment-2"></span>
                                <span id="strength-segment-3" class="rounded-r-full"></span>
                            </div>
                        </div>

                        <div class="relative">
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password"
                                required 
                                class="form-input peer w-full px-3 border rounded-md bg-transparent
                                        border-gray-300 focus:outline-none pr-10 <?= isset($validation) && $validation->hasError('confirm_password') ? 'invalid' : '' ?>"
                                placeholder=" "
                                style="padding-top: 1rem; padding-bottom: 0.85rem;"
                            >
                            <label 
                                for="confirm_password"
                                class="absolute left-3 bg-white px-1
                                        transition-all duration-200 pointer-events-none
                                        text-gray-500
                                        peer-placeholder-shown:text-base
                                        peer-placeholder-shown:top-[1.1rem]
                                        peer-placeholder-shown:-translate-y-0
                                        peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                        <?= isset($validation) && $validation->hasError('confirm_password') ? 'text-red-500' : '' ?>" 
                            >
                                Confirmar Contraseña
                            </label>
                            <span class="password-toggle-icon" onclick="togglePasswordVisibility('confirm_password')">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path id="confirm_password-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="confirm_password-icon-path2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </span>
                            <div class="error-message <?= isset($validation) && $validation->hasError('confirm_password') ? '' : 'hidden' ?>">
                                <?= isset($validation) ? $validation->getError('confirm_password') : '' ?>
                            </div>
                        </div>

                        <?php if ($rol === 'vendedor'): ?>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="nombre_empresa" 
                                    name="nombre_empresa"
                                    required 
                                    maxlength="100"
                                    class="form-input peer w-full px-3 border rounded-md bg-transparent
                                            border-gray-300 focus:outline-none <?= isset($validation) && $validation->hasError('nombre_empresa') ? 'invalid' : '' ?>"
                                    placeholder=" "
                                    value="<?= old('nombre_empresa') ?>"
                                    style="padding-top: 1rem; padding-bottom: 0.85rem;"
                                >
                                <label 
                                    for="nombre_empresa"
                                    class="absolute left-3 bg-white px-1
                                            transition-all duration-200 pointer-events-none
                                            text-gray-500
                                            peer-placeholder-shown:text-base
                                            peer-placeholder-shown:top-[1.1rem]
                                            peer-placeholder-shown:-translate-y-0
                                            peer-focus:top-[-0.5rem] peer-focus:text-xs peer-focus:text-[#fd8c00]
                                            <?= isset($validation) && $validation->hasError('nombre_empresa') ? 'text-red-500' : '' ?>" 
                                >
                                    Nombre de la Empresa
                                </label>
                                <div class="error-message <?= isset($validation) && $validation->hasError('nombre_empresa') ? '' : 'hidden' ?>">
                                    <?= isset($validation) ? $validation->getError('nombre_empresa') : '' ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-start mt-4">
                        <div class="flex items-center h-5">
                            <input 
                                id="terminos" 
                                name="terminos" 
                                type="checkbox" 
                                required
                                class="focus:ring-[#fd8c00] h-4 w-4 text-[#fd8c00] border-gray-300 rounded"
                                <?= old('terminos') ? 'checked' : '' ?>
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terminos" class="font-medium text-gray-700">
                                Acepto los <a href="#" class="text-[#fd8c00] hover:text-[#e67e00]">términos y condiciones</a>
                            </label>
                            <div id="terminos-error" class="error-message <?= isset($validation) && $validation->hasError('terminos') ? '' : 'hidden' ?> mt-1">
                                <?= isset($validation) ? $validation->getError('terminos') : 'Debes aceptar los términos y condiciones' ?>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        id="submit-btn"
                        disabled
                        class="w-full bg-gray-400 text-white 
                               py-4 px-6 rounded-md font-bebas text-2xl 
                               transition-all duration-300
                               shadow-lg mt-6"
                    >
                        COMPLETAR REGISTRO
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 relative p-2">
        <div class="relative w-full h-full rounded-xl overflow-hidden shadow-lg">
            <?php 
                $imageSrc = ($rol === 'vendedor') ? base_url('public/images/assets/proveedor.jpg') : base_url('public/images/assets/Motero.jpg');
                $imageAlt = ($rol === 'vendedor') ? 'Proveedor RoarMot' : 'Moto RoarMot';
                $imageClass = ($rol === 'vendedor') ? 'right-[-40%]' : 'left-[-15%]';
            ?>
            <img id="perfil-image" src="<?= esc($imageSrc) ?>" alt="<?= esc($imageAlt) ?>" 
                 class="absolute h-full w-auto max-w-none transition-all duration-300 <?= esc($imageClass) ?>">
        </div>
    </div>

<script>
    // Cuando el DOM está completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. OBTENER DATOS DEL PHP (ya no de la URL) ---
        // El email y rol ya se pasan directamente a la vista desde el controlador
        // y se establecen en los campos ocultos del formulario.
        const email = document.getElementById('email').value;
        const rol = document.getElementById('rol').value;

        // --- 2. CAMBIAR IMAGEN SEGÚN ROL (ya hecho en PHP, pero el JS de posicionamiento aún es útil) ---
        const perfilImage = document.getElementById('perfil-image');
        if (perfilImage) {
            // No cambiamos el src aquí, ya lo hace PHP. Solo ajustamos la clase de posicionamiento si es necesario.
            // Limpiar clases de posicionamiento previas (si el DOM ya las tuviera)
            perfilImage.classList.remove('left-[-15%]', 'right-[-40%]');

            if (rol === 'vendedor') {
                perfilImage.classList.add('right-[-40%]'); // Posicionamiento específico
            } else { 
                perfilImage.classList.add('left-[-15%]'); // Posicionamiento específico
            }
        }

        // --- 3. OBTENER ELEMENTOS DEL FORMULARIO ---
        const formulario = document.getElementById('formularioPaso3');
        const inputsToValidate = document.querySelectorAll('.form-input');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password'); // Nuevo
        const passwordStrengthBar = document.getElementById('password-strength-bar');
        const strengthSegments = [
            document.getElementById('strength-segment-1'),
            document.getElementById('strength-segment-2'),
            document.getElementById('strength-segment-3')
        ];
        const terminosCheckbox = document.getElementById('terminos');
        const terminosError = document.getElementById('terminos-error');
        const submitBtn = document.getElementById('submit-btn');

        // --- 4. FUNCIÓN PARA VERIFICAR VALIDEZ DEL FORMULARIO ---
        function checkFormValidity() {
            let formIsValid = true;
            
            // Verificar cada input
            inputsToValidate.forEach(input => {
                // Validación básica de HTML5 y verificación de no vacío
                if (!input.checkValidity() || input.value.trim() === '') {
                    formIsValid = false;
                }
                
                // Validación adicional para contraseña y confirmación
                if (input.id === 'password' && input.value.trim() !== '') {
                    const passwordStrengthValid = checkPasswordStrength(false); // Validar sin mostrar alerta
                    if (!passwordStrengthValid) {
                        formIsValid = false;
                    }
                }
                if (input.id === 'confirm_password' && passwordInput.value !== confirmPasswordInput.value) {
                    formIsValid = false;
                }
            });
            
            // Verificar términos aceptados
            if (!terminosCheckbox.checked) {
                formIsValid = false;
            }
            
            // Habilitar/deshabilitar botón según validación
            if (formIsValid) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-400');
                submitBtn.classList.add('bg-red-600', 'hover:bg-[#fd8c00]', 'hover:scale-[1.02]', 'hover:shadow-xl');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-red-600', 'hover:bg-[#fd8c00]', 'hover:scale-[1.02]', 'hover:shadow-xl');
                submitBtn.classList.add('bg-gray-400');
            }
        }

        // --- 5. VALIDACIÓN Y ESTILOS PARA INPUTS ---
        function validateAndStyleInput(input) {
            const value = input.value.trim();
            const parentDiv = input.closest('.relative');
            const errorMessageDiv = parentDiv.querySelector('.error-message');
            const label = parentDiv.querySelector('label');
            const originalErrorMsg = input.dataset.errorMsg;

            // Validación básica
            let isValid = input.checkValidity();
            let currentErrorMessage = originalErrorMsg;

            // Validación especial para contraseña
            if (input.id === 'password' && value.length > 0) {
                const passwordStrengthValid = checkPasswordStrength(false);
                if (!passwordStrengthValid) {
                    isValid = false;
                    currentErrorMessage = errorMessageDiv.textContent; // Usar mensaje de fortaleza
                }
            } else if (input.id === 'confirm_password') { // Validación para confirmar contraseña
                if (passwordInput.value !== confirmPasswordInput.value.trim()) { // Added .trim()
                    isValid = false;
                    currentErrorMessage = 'Las contraseñas no coinciden.';
                }
            }
            
            // Limpiar clases previas
            input.classList.remove('valid', 'invalid', 'shake', 'border-gray-300', 'border-red-500', 'border-green-500', 'border-[#fd8c00]');
            label.classList.remove('text-red-500', 'text-green-500', 'text-gray-500', 'text-[#fd8c00]');

            // Lógica de estilos según estado
            if (value === '') {
                // Estado vacío
                input.classList.add('border-gray-300');
                label.classList.add('text-gray-500');
                errorMessageDiv.classList.add('hidden');
                input.setCustomValidity('');
                if (input.id === 'password') {
                    passwordStrengthBar.classList.add('hidden');
                }
            } else if (isValid) {
                // Estado válido
                input.classList.add('valid');
                label.classList.add('text-green-500');
                errorMessageDiv.classList.add('hidden');
                if (input.id === 'password') {
                    passwordStrengthBar.classList.remove('hidden');
                }
            } else {
                // Estado inválido
                input.classList.add('invalid', 'shake');
                label.classList.add('text-red-500');
                errorMessageDiv.textContent = currentErrorMessage;
                errorMessageDiv.classList.remove('hidden');
                if (input.id === 'password') {
                    passwordStrengthBar.classList.remove('hidden');
                }
            }
            checkFormValidity();
        }

        // --- 6. VERIFICAR FORTALEZA DE CONTRASEÑA ---
        function checkPasswordStrength(showAlerts = true) {
            const password = passwordInput.value;
            const errorMessageDiv = passwordInput.closest('.relative').querySelector('.error-message');
            let strength = 0;
            let missingRequirements = [];
            let isValidPassword = true;

            // Expresiones regulares para validar requisitos
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            const isMinLength = password.length >= 8;

            // Calcular fortaleza (1 punto por cada requisito cumplido)
            if (hasUppercase) strength++;
            else if (showAlerts) missingRequirements.push('una mayúscula');
            
            if (hasLowercase) strength++;
            else if (showAlerts) missingRequirements.push('una minúscula');

            if (hasNumber) strength++;
            else if (showAlerts) missingRequirements.push('un número');

            if (hasSpecialChar) strength++;
            else if (showAlerts) missingRequirements.push('un carácter especial');

            // Validar longitud mínima
            if (!isMinLength) {
                if (showAlerts) missingRequirements.push('al menos 8 caracteres');
                isValidPassword = false;
            }

            // Mostrar mensaje de requisitos faltantes si es necesario
            if (missingRequirements.length > 0 && showAlerts) {
                errorMessageDiv.textContent = `La contraseña debe contener: ${missingRequirements.join(', ')}.`;
                errorMessageDiv.classList.remove('hidden');
                isValidPassword = false;
            } else {
                if (isMinLength) { // Solo ocultar si la longitud mínima se cumple
                    errorMessageDiv.classList.add('hidden');
                }
            }
            
            // Actualizar barra de fortaleza visual
            strengthSegments.forEach((segment, index) => {
                if (index < strength) {
                    if (strength === 1) segment.style.backgroundColor = '#ef4444'; // Rojo (débil)
                    else if (strength === 2) segment.style.backgroundColor = '#f97316'; // Naranja (media)
                    else if (strength >= 3) segment.style.backgroundColor = '#22c55e'; // Verde (fuerte)
                } else {
                    segment.style.backgroundColor = '#e2e8f0'; // Gris claro (vacío)
                }
            });

            // Si la contraseña está vacía, ocultar la barra
            if (password.length === 0) {
                passwordStrengthBar.classList.add('hidden');
            } else {
                passwordStrengthBar.classList.remove('hidden');
            }

            return isValidPassword;
        }

        // --- 7. FUNCIÓN PARA MOSTRAR/OCULTAR CONTRASEÑA ---
        window.togglePasswordVisibility = function(fieldId) {
            const input = document.getElementById(fieldId);
            const iconPath = document.getElementById(fieldId + '-icon-path');
            const iconPath2 = document.getElementById(fieldId + '-icon-path2'); // Para el segundo path del ojo

            if (input.type === 'password') {
                input.type = 'text';
                // Cambiar icono a ojo abierto (visible)
                iconPath.setAttribute('d', 'M.04 12c1.274 4.057 5.064 7 9.542 7 4.478 0 8.268-2.943 9.542-7-1.274-4.057-5.064-7-9.542-7-4.477 0-8.268 2.943-9.542 7z'); // Path del ojo abierto
                iconPath2.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'); // Path del círculo central
            } else {
                input.type = 'password';
                // Cambiar icono a ojo cerrado (oculto)
                iconPath.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'); // Path del círculo central
                iconPath2.setAttribute('d', 'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'); // Path del ojo cerrado
            }
        };

        // --- 8. MANEJO DE EVENTOS ---
        inputsToValidate.forEach(input => {
            input.addEventListener('input', () => validateAndStyleInput(input));
            input.addEventListener('blur', () => validateAndStyleInput(input));
            input.addEventListener('focus', function() {
                // Limpiar estilos de error al enfocar
                this.classList.remove('invalid', 'shake');
                this.closest('.relative').querySelector('.error-message').classList.add('hidden');
                this.previousElementSibling.classList.remove('text-red-500', 'text-green-500');
                this.previousElementSibling.classList.add('text-[#fd8c00]');
            });
        });

        passwordInput.addEventListener('input', checkPasswordStrength);
        passwordInput.addEventListener('blur', checkPasswordStrength);
        confirmPasswordInput.addEventListener('input', () => validateAndStyleInput(confirmPasswordInput));
        confirmPasswordInput.addEventListener('blur', () => validateAndStyleInput(confirmPasswordInput));

        terminosCheckbox.addEventListener('change', checkFormValidity); // Validar al cambiar el checkbox

        // --- 9. MANEJO DE MENSAJES FLASH (del servidor) ---
        function showAlert(message, type) {
            const alertaDiv = document.getElementById('alerta');
            const mensajeSpan = document.getElementById('mensaje-alerta');
            
            mensajeSpan.textContent = message;
            alertaDiv.classList.remove('hidden', 'bg-green-600', 'bg-red-600', 'bg-blue-600');
            
            if (type === 'success') {
                alertaDiv.classList.add('bg-green-600');
            } else if (type === 'error') {
                alertaDiv.classList.add('bg-red-600');
            } else if (type === 'info') {
                alertaDiv.classList.add('bg-blue-600');
            }
            
            setTimeout(() => {
                alertaDiv.classList.add('hidden');
            }, 4000); // Ocultar después de 4 segundos
        }

        // Llamar a showAlert para los mensajes flash existentes de CodeIgniter
        <?php if (session()->getFlashdata('success_message')): ?>
            showAlert('<?= esc(session()->getFlashdata('success_message')) ?>', 'success');
        <?php elseif (session()->getFlashdata('error_message')): ?>
            showAlert('<?= esc(session()->getFlashdata('error_message')) ?>', 'error');
        <?php endif; ?>

        // --- 10. INICIALIZACIÓN AL CARGAR LA PÁGINA ---
        checkFormValidity(); // Validar el formulario al cargar para habilitar/deshabilitar el botón
        if (passwordInput.value.length > 0) {
            checkPasswordStrength(); // Mostrar fortaleza si ya hay contraseña
        }
    });
</script>
</body>
</html>