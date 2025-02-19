<?php
session_start();
include_once 'admin/components/init.php';
include_once 'components/header.php';

iniciarSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'La Gema'; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Agrega tu archivo de estilos si es necesario -->
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <main class="flex-1 max-w-4xl mx-auto px-4 flex items-center justify-center h-screen">
        <section class="bg-white rounded-lg p-6 shadow-lg text-center">
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow-xl flex items-center gap-4">
                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
                <div>
                    <p class="font-semibold text-xl">En mantenimiento 🎟️</p>
                    <p class="mt-2 text-lg">Estamos preparando nuevas sorpresas para ti. Vuelve pronto para participar y ganar increíbles premios. 🏆</p>
                </div>
            </div>
        </section>
    </main>

<?php include_once 'components/footer.php'; ?>
</body>
</html>
