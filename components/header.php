<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'La Gema'; ?></title>
  <link rel="icon" href="<?php echo HOST;?>assets/images/logo.ico" type="image/x-icon">
    <!-- App css -->
  <link href="<?php echo HOST;?>assets/css/app.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">

    <!-- Icons css -->
  <link href="<?php echo HOST;?>assets/css/icons.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">
  <link href="<?php echo HOST;?>assets/css/icons.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">
  <link href="<?php echo HOST;?>assets/css/output.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">
  <link href="<?php echo HOST;?>assets/css/swal2.min.css?v=<?php echo VERSION_JS;?>" rel="stylesheet">

  <!-- JS de SweetAlert -->
  <script src="<?php echo HOST;?>/assets/js/swal.js?v=<?php echo VERSION_JS;?>"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <div class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="w-full shadow-lg mb-8 bg-primary">
      <nav class="container mx-auto flex justify-center items-center py-6">
        <a href="<?php echo HOST;?>">
        <img src="<?php echo HOST;?>assets/images/logo.png" alt="Logo" class="w-40">
        </a>
      </nav>
    </header>