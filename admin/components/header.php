<?php 
    require __DIR__.'../../../conf/config.php';
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo HOST;?>/assets/images/logo.ico">
    <!-- App css -->
    <link href="<?php echo HOST;?>assets/css/app.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="<?php echo HOST;?>assets/css/icons.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <link href="<?php echo HOST;?>assets/css/output.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <link href="<?php echo HOST;?>assets/css/swal2.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet">

    <!-- JS de SweetAlert -->
    <script src="<?php echo HOST;?>/assets/js/swal.js?v=<?php echo VERSION_JS;?>"></script>

    <!-- jQuery -->
    <script src="<?php echo HOST_ADMIN;?>/assets/js/jquery.js?v=<?php echo VERSION_JS;?>"></script>

    <!-- Theme Config Js -->
    <script src="<?php echo HOST_ADMIN;?>/assets/js/config.js?v=<?php echo VERSION_JS;?>"></script>
</head>

<body>

    <div class="flex wrapper">

        <!-- Sidenav Menu -->
        <div class="app-menu">

            <!-- App Logo -->
            <a href="<?php echo HOST_ADMIN;?>" class="logo-box">
                <!-- Light Logo -->
                <div class="logo-light">
                    <img src="<?php echo HOST;?>assets/images/logo.png" width="150px" alt="Light logo">
                </div>

                <!-- Dark Logo -->
                <div class="logo-dark">
                    <img src="<?php echo HOST;?>assets/images/logo.png" width="150px" alt="Dark logo">
                </div>
            </a>

            <!-- Sidenav Menu Toggle Button -->
            <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5 z-50">
                <span class="sr-only">Menu Toggle Button</span>
                <i class="ri-checkbox-blank-circle-line text-xl"></i>
            </button>

            <!--- Menu -->
            <div class="scrollbar" data-simplebar>
                <ul class="menu" data-fc-type="accordion">

                    <li class="menu-item">
                        <a href="<?php echo HOST_ADMIN;?>" class="menu-link">
                            <span class="menu-icon"><i class="ri-pages-line"></i></span>
                            <span class="menu-text"> Rifas </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="<?php echo HOST_ADMIN;?>pagos" class="menu-link">
                            <span class="menu-icon"><i class="ri-share-line"></i></span>
                            <span class="menu-text"> Pagos </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="<?php echo HOST_ADMIN;?>logout" id="logout" class="menu-link">
                            <span class="menu-icon"><i class="ri-logout-circle-r-line"></i></span>
                            <span class="menu-text"> Salir </span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>

        <div class="page-content">

            <!-- Topbar Start -->
            <header class="app-header flex items-center px-4 gap-3.5">

                <!-- App Logo -->
                <a href="/" class="logo-box">
                    <!-- Light Logo -->
                    <div class="logo-light">
                        <img src="<?php echo HOST;?>assets/images/logo.png" width="150px" alt="Light logo">
                    </div>

                    <!-- Dark Logo -->
                    <div class="logo-dark">
                        <img src="<?php echo HOST;?>assets/images/logo.png" width="150px" alt="Light logo">
                    </div>
                </a>

                <!-- Sidenav Menu Toggle Button -->
                <button id="button-toggle-menu" class="nav-link p-2">
                    <span class="sr-only">Menu Toggle Button</span>
                    <span class="flex items-center justify-center">
                        <i class="ri-menu-2-fill text-2xl"></i>
                    </span>
                </button>

            </header>