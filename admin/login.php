<?php 
    session_start();
    require __DIR__.'../../conf/config.php';
    if (!isset($_SESSION['auth'])) {
        $_SESSION['auth'] = bin2hex(random_bytes(16));
        session_regenerate_id(true); 
    }    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icono del sitio -->
    <link rel="icon" href="<?php echo HOST;?>assets/images/logo.ico" type="image/x-icon">

    <!-- CSS de la aplicación -->
    <link href="<?php echo HOST;?>assets/css/app.min.css?v1=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <!-- CSS de iconos -->
    <link href="<?php echo HOST;?>assets/css/icons.min.css?v1=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <!-- SweetAlert CSS -->
    <link href="<?php echo HOST;?>assets/css/swal2.min.css?v1=<?php echo VERSION_JS;?>" rel="stylesheet">

    <link href="<?php echo HOST;?>assets/css/output.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

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
                            <img src="<?php echo HOST;?>/assets/images/logo.png" alt="logo" class="w-32 block">
                        </a>
                    </div>

                    <div class="p-9">
                        <div class="text-center mx-auto w-3/4">
                            <h4 class="text-dark/70 text-center text-lg font-bold dark:text-light/80 mb-2">¡Bienvenido de nuevo!</h4>
                            <p class="text-gray-400 mb-9">Por favor, ingresa tu correo electrónico y contraseña para continuar.</p>
                        </div>

                        <form id="login-form" data-url="<?php echo HOST_ADMIN; ?>acciones/login.php">

                            <div class="mb-6 space-y-2">
                                <label for="email" class="font-semibold text-gray-500">Dirección de correo electrónico</label>
                                <input class="form-input" type="email" id="email" name="email" required="" placeholder="Introduce tu correo electrónico">
                            </div>

                            <div class="mb-6 space-y-2">
                                <div class="flex justify-between items-center mb-2">
                                    <label for="password" class="font-semibold text-gray-500">Contraseña</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="password" id="password" name="password" class="form-input rounded-e-none" placeholder="Introduce tu contraseña">
                                    <span id="eye-icon" class="px-3 py-1 border rounded-e-md -ms-px dark:border-white/10 cursor-pointer"><i class="ri-eye-line text-lg"></i></span>
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
    <script src="<?php echo HOST_ADMIN;?>assets/js/swal.js?v1=<?php echo VERSION_JS;?>"></script>

    <!-- jQuery -->
    <script src="<?php echo HOST_ADMIN;?>assets/js/jquery.js?v1=<?php echo VERSION_JS;?>"></script>

    <script src="<?php echo HOST_ADMIN;?>assets/js/login.js?v1=<?php echo VERSION_JS;?>"></script>

</body>

</html>
