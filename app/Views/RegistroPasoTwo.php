<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Código | RoarMot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        .bg-cream { background-color: #FBF9F7; }
        .input-error { border-color: #ef4444 !important; }
        .error-message { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; }
        .code-input { letter-spacing: 0.5rem; }
        .code-input.error {
            border-color: #ef4444 !important;
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="bg-cream min-h-screen flex relative">

    <div id="alerta-flash" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full">
        <span id="mensaje-alerta-flash"></span>
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
                <h1 class="font-bebas text-4xl text-gray-800 text-center mb-2">VALIDA TU CÓDIGO</h1>
                <p class="text-gray-600 text-center mb-8">Hemos enviado un código de 6 dígitos a<br><span id="email-mostrado" class="font-semibold"></span></p>
                
                <form class="mt-8 space-y-6" id="formularioPaso2" action="<?= base_url('registro/validarCodigo') ?>" method="post">

                    <div class="flex justify-center space-x-3 mb-8">
                        <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input" 
                               oninput="moveToNext(this, 0)"> <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input"
                               oninput="moveToNext(this, 1)" onkeydown="moveToPrevious(event, this, 1)">
                        <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input"
                               oninput="moveToNext(this, 2)" onkeydown="moveToPrevious(event, this, 2)">
                        <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input"
                               oninput="moveToNext(this, 3)" onkeydown="moveToPrevious(event, this, 3)">
                        <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input"
                               oninput="moveToNext(this, 4)" onkeydown="moveToPrevious(event, this, 4)">
                        <input type="text" maxlength="1" class="w-12 h-16 text-3xl text-center border-2 border-gray-300 rounded-md focus:border-[#fd8c00] focus:outline-none code-input"
                               onkeydown="moveToPrevious(event, this, 5)"> <input type="hidden" name="codigo" id="codigo-completo">
                    </div>

                    <?php if (isset($validation) && $validation->hasError('codigo')): ?>
                        <div class="error-message text-center">
                            <?= $validation->getError('codigo') ?>
                        </div>
                    <?php endif; ?>
                    <div id="error-codigo-client" class="error-message text-center hidden"></div>

                    <button type="submit" 
                            id="validarCodigoBtn"
                            class="w-full bg-red-600 hover:bg-[#fd8c00] text-white 
                                   py-4 px-6 rounded-md font-bebas text-2xl 
                                   transition-all duration-300 transform hover:scale-[1.02]
                                   shadow-lg hover:shadow-xl">
                        VALIDAR CÓDIGO
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-gray-600 text-sm">
                            ¿No recibiste el código? 
                            <button type="button" id="reenviarCodigoBtn" class="text-[#fd8c00] hover:underline focus:outline-none">
                                Reenviar código
                            </button>
                        </p>
                        <div id="tiempo-restante" class="text-gray-500 text-sm mt-1 hidden">Podrás reenviar en <span id="contador">60</span> segundos</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 relative">
        <div class="absolute inset-0 flex items-center justify-center p-2">
            <div class="relative w-full h-full rounded-xl overflow-hidden shadow-lg">
                <img id="dynamic-bg-image" src="<?= base_url('public/images/assets/Motero.jpg') ?>" alt="Moto RoarMot" 
                     class="absolute h-full w-auto max-w-none transition-all duration-300">
            </div>
        </div>
    </div>

    <script>
        // Declarar variables a nivel de scope superior para accesibilidad en funciones
        let emailMostrado;
        let rolUsuario;
        let intervaloContador; // Para el temporizador de reenviar código

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Obtener email y rol de los datos pasados por el controlador
            // Estos valores se pasarán desde el controlador a la vista usando $data['email'] y $data['rol']
            emailMostrado = "<?= esc($email ?? 'usuario@ejemplo.com') ?>"; // Usar el valor PHP
            rolUsuario = "<?= esc($rol ?? 'comprador') ?>"; // Usar el valor PHP

            document.getElementById('email-mostrado').textContent = emailMostrado;

            // 2. Lógica para cambiar la imagen de fondo según el rol
            const dynamicBgImage = document.getElementById('dynamic-bg-image'); 
            if (dynamicBgImage) {
                if (rolUsuario === 'vendedor') { 
                    dynamicBgImage.src = "<?= base_url('public/images/assets/proveedor.jpg') ?>";
                    dynamicBgImage.alt = 'Proveedor RoarMot';
                    dynamicBgImage.classList.add('right-[-40%]');
                    dynamicBgImage.classList.remove('left-[-15%]');
                } else { // Si el rol es 'comprador' o por defecto
                    dynamicBgImage.src = "<?= base_url('public/images/assets/Motero.jpg') ?>";
                    dynamicBgImage.alt = 'Moto RoarMot';
                    dynamicBgImage.classList.add('left-[-15%]');
                    dynamicBgImage.classList.remove('right-[-40%]');
                }
            }

            // 3. Funciones de movimiento entre inputs de código
            const codeInputs = document.querySelectorAll('.code-input');
            
            codeInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length === this.maxLength) {
                        if (index < codeInputs.length - 1) {
                            codeInputs[index + 1].focus();
                        }
                    }
                    validateCodeInput(); // Validar al escribir
                });

                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace' && this.value.length === 0) {
                        if (index > 0) {
                            codeInputs[index - 1].focus();
                        }
                    }
                });

                input.addEventListener('focus', function() {
                    this.classList.remove('error'); // Quitar error al enfocar
                });
            });

            // 4. Función para validar el código completo (en el cliente)
            function validateCodeInput() {
                let codigoCompleto = '';
                codeInputs.forEach(input => {
                    codigoCompleto += input.value;
                });
                document.getElementById('codigo-completo').value = codigoCompleto; // Actualizar input oculto
            }

            // 5. Gestión del botón de reenviar código y temporizador
            const reenviarCodigoBtn = document.getElementById('reenviarCodigoBtn');
            const contadorSpan = document.getElementById('contador');
            const tiempoRestanteDiv = document.getElementById('tiempo-restante');
            let tiempoRestante = 60;

            function iniciarContador() {
                reenviarCodigoBtn.disabled = true; // Deshabilitar el botón de reenviar
                tiempoRestanteDiv.classList.remove('hidden');
                contadorSpan.textContent = tiempoRestante;

                intervaloContador = setInterval(() => {
                    tiempoRestante--;
                    contadorSpan.textContent = tiempoRestante;
                    if (tiempoRestante <= 0) {
                        clearInterval(intervaloContador);
                        reenviarCodigoBtn.disabled = false; // Habilitar el botón
                        tiempoRestanteDiv.classList.add('hidden');
                        tiempoRestante = 60; // Resetear tiempo para el próximo envío
                    }
                }, 1000);
            }

            // Iniciar contador al cargar la página
            iniciarContador();

            reenviarCodigoBtn.addEventListener('click', async function() {
                // Aquí, haremos una petición AJAX al servidor para reenviar el código
                // Esto es crucial para que el servidor genere y envíe un nuevo código.
                
                // Mostrar alerta de "Enviando..."
                showAlert('Enviando nuevo código...', 'info');

                try {
                    const response = await fetch('<?= base_url('registro/reenviarCodigo') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest' // Indica que es una petición AJAX
                        },
                        body: JSON.stringify({ email: emailMostrado }) // Enviamos el email
                    });

                    const data = await response.json(); // Esperamos una respuesta JSON

                    if (response.ok && data.success) {
                        showAlert(data.message, 'success');
                        iniciarContador(); // Reiniciar el contador si el reenvío fue exitoso
                    } else {
                        showAlert(data.message || 'Error al reenviar el código.', 'error');
                    }
                } catch (error) {
                    console.error('Error al reenviar código:', error);
                    showAlert('Ocurrió un error de red al reenviar el código.', 'error');
                }
            });

            // 6. Manejo de la alerta flash (para mensajes del servidor o JS)
            function showAlert(message, type) {
                const alertaFlash = document.getElementById('alerta-flash');
                const mensajeAlertaFlash = document.getElementById('mensaje-alerta-flash');

                mensajeAlertaFlash.textContent = message;
                alertaFlash.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold text-center max-w-md w-full';

                if (type === 'success') {
                    alertaFlash.classList.add('bg-green-600');
                } else if (type === 'error') {
                    alertaFlash.classList.add('bg-red-600');
                } else if (type === 'info') {
                    alertaFlash.classList.add('bg-blue-600');
                }
                
                alertaFlash.classList.remove('hidden');

                setTimeout(() => {
                    alertaFlash.classList.add('hidden');
                }, 4000); // Ocultar después de 4 segundos
            }

            // Llamar a showAlert para los mensajes flash existentes de CodeIgniter
            // Usamos un pequeño truco para pasar la data de PHP a JS de forma segura
            <?php if (session()->getFlashdata('success_message')): ?>
                showAlert('<?= esc(session()->getFlashdata('success_message')) ?>', 'success');
            <?php elseif (session()->getFlashdata('error_message')): ?>
                showAlert('<?= esc(session()->getFlashdata('error_message')) ?>', 'error');
            <?php endif; ?>

            // 7. Validación del formulario al enviar (client-side)
            const formularioPaso2 = document.getElementById('formularioPaso2');
            formularioPaso2.addEventListener('submit', function(e) {
                // Antes de enviar, asegúrate de que el input oculto 'codigo-completo' tenga el valor correcto
                validateCodeInput(); 

                const codigoIngresado = document.getElementById('codigo-completo').value;
                const errorCodigoClient = document.getElementById('error-codigo-client');

                if (codigoIngresado.length !== 6) {
                    e.preventDefault(); // Prevenir el envío si el código no tiene 6 dígitos
                    errorCodigoClient.textContent = 'El código debe tener 6 dígitos.';
                    errorCodigoClient.classList.remove('hidden');
                    // Agrega la animación de error a todos los inputs
                    codeInputs.forEach(input => {
                        input.classList.add('error');
                        setTimeout(() => { input.classList.remove('error'); }, 1000);
                    });
                } else {
                    errorCodigoClient.classList.add('hidden');
                    // El formulario se enviará de forma normal al action de PHP
                }
            });
        });
    </script>

    <script>
        //lógoca para reenvair el código 
        document.addEventListener('DOMContentLoaded', function() {
            const reenviarBtn = document.getElementById('reenviarCodigoBtn');
            const emailParaReenviar = "<?php echo $email; ?>"; // Obtener el email del PHP

            if (reenviarBtn) {
                reenviarBtn.addEventListener('click', function() {
                    // Deshabilitar el botón para evitar múltiples clics
                    reenviarBtn.disabled = true;
                    reenviarBtn.textContent = 'Enviando...';

                    fetch('<?= base_url('registro/reenviar-codigo') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest' // Indica que es una petición AJAX
                        },
                        body: JSON.stringify({ email: emailParaReenviar })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('¡Nuevo código enviado con éxito!'); // Mensaje de éxito
                            // Aquí puedes iniciar el contador de 60 segundos si lo tienes
                            // Ejemplo: iniciarContador();
                        } else {
                            alert('Error al reenviar el código: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error de red al intentar reenviar el código.');
                    })
                    .finally(() => {
                        // Re-habilitar el botón después de la respuesta
                        reenviarBtn.disabled = false;
                        reenviarBtn.textContent = 'Reenviar código';
                    });
                });
            }
        });
    </script>
</body>
</html>