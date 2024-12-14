<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Juega y Gana'; ?></title>
  <link rel="icon" href="assets/images/logo.ico" type="image/x-icon">
    <!-- App css -->
  <link href="<?php echo HOST_ADMIN;?>assets/css/app.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <!-- Icons css -->
  <link href="<?php echo HOST_ADMIN;?>assets/css/icons.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

  <script src="https://cdn.tailwindcss.com"></script>

  <link href="<?php echo HOST_ADMIN;?>assets/css/swal2.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet">

</head>

<body class="bg-gray-100 text-gray-800">

  <div class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="w-full bg-white shadow-lg mb-8">
      <nav class="container mx-auto flex justify-center items-center py-6">
        <a href="/">
        <img src="assets/images/logo.png" alt="Logo" class="w-40">
        </a>
      </nav>
    </header>