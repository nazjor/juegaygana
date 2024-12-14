<?php require __DIR__.'../../conf/config.php';?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icono del sitio -->
    <link rel="icon" href="<?php echo HOST;?>assets/images/logo.ico" type="image/x-icon">

    <!-- CSS de la aplicación -->
    <link href="<?php echo HOST_ADMIN;?>assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- CSS de iconos -->
    <link href="<?php echo HOST_ADMIN;?>assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <!-- SweetAlert CSS -->
    <link href="<?php echo HOST_ADMIN;?>assets/css/swal2.min.css" rel="stylesheet">

</head>

<body class="relative flex flex-col">

    <!-- Tarjeta de Inicio de Sesión -->
    <div class="relative flex flex-col items-center justify-center h-screen">
        <div class="flex justify-center">
            <div class="max-w-md px-4 mx-auto">
                <div class="card overflow-hidden">

                    <!-- Logo -->
                    <div class="p-9 bg-primary">
                        <a href="<?php echo HOST;?>" class="flex justify-center">
                            <img src="<?php echo HOST_ADMIN;?>/assets/images/logo.png" alt="logo" class="w-32 block">
                        </a>
                    </div>

                    <div class="p-9">
                        <div class="text-center mx-auto w-3/4">
                            <h4 class="text-dark/70 text-center text-lg font-bold dark:text-light/80 mb-2">¡Bienvenido de nuevo!</h4>
                            <p class="text-gray-400 mb-9">Por favor, ingresa tu correo electrónico y contraseña para continuar.</p>
                        </div>

                        <form id="login-form" method="POST">

                            <div class="mb-6 space-y-2">
                                <label for="emailaddress" class="font-semibold text-gray-500">Dirección de correo electrónico</label>
                                <input class="form-input" type="email" id="emailaddress" name="email" required="" placeholder="Introduce tu correo electrónico">
                            </div>

                            <div class="mb-6 space-y-2">
                                <div class="flex justify-between items-center mb-2">
                                    <label for="password" class="font-semibold text-gray-500">Contraseña</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="password" id="password" name="password" class="form-input rounded-e-none" placeholder="Introduce tu contraseña">
                                    <span class="px-3 py-1 border rounded-e-md -ms-px dark:border-white/10"><i class="ri-eye-line text-lg"></i></span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" class="form-checkbox rounded text-primary" id="checkbox-signin" checked>
                                    <label class="ms-2" for="checkbox-signin">Recordarme</label>
                                </div>
                            </div>

                            <div class="text-center mb-6">
                                <button class="btn bg-primary text-white" type="submit"> Iniciar Sesión </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS de SweetAlert -->
    <script src="<?php echo HOST_ADMIN;?>assets/js/swal.js"></script>

    <!-- jQuery -->
    <script src="<?php echo HOST_ADMIN;?>assets/js/jquery.js"></script>

    <script>
        $(document).ready(function () {
            // Al enviar el formulario
            $('#login-form').submit(function (e) {
            e.preventDefault();

            // Obtener los datos del formulario
            var email = $('#emailaddress').val().trim();
            var password = $('#password').val().trim();

            // Validar campos antes de enviar la solicitud
            if (email === '' || password === '') {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Campos vacíos!',
                    text: 'Por favor, complete todos los campos.',
                    confirmButtonText: 'Aceptar'
                });
                return; // Detener ejecución si hay campos vacíos
            }

            // Enviar la solicitud AJAX
            $.ajax({
                url: '<?php echo HOST_ADMIN;?>acciones/login.php', // Ruta del script que maneja la autenticación
                type: 'POST',
                data: { email: email, password: password },
                success: function (response) {
                    try {
                        console.log(response);
                        window.location.href = `<?php echo HOST_ADMIN;?>`;
                    } catch (err) {
                        console.log(err);
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error inesperado!',
                            text: 'La respuesta del servidor no es válida.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Mostrar detalles del error si es posible
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error de red!',
                        text: `Hubo un problema con la solicitud: ${textStatus}. Intenta de nuevo.`,
                        footer: `Detalles del error: ${errorThrown}`,
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });

        });
    </script>
</body>

</html>
