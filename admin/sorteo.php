<?php
// Incluir archivos de configuración y bibliotecas
require __DIR__ . '../../conf/config.php';
require_once DIRPAGE_ADMIN . 'components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/BoletosRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';

// Iniciar sesión y validar autenticación
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Inicializar repositorios y obtener información de la rifa activa
$rifaRepo = new RifaRepository();
$pagosRepo = new PagosRepository();
$boletoRepo = new BoletosRepository();
$rifaActiva = $rifaRepo->findActiveRifa();

// Validar si hay rifas activas
$error = $rifaActiva ? null : "¡No hay rifas activas en este momento!";

// Verificar disponibilidad de boletos
if ($error == null) {
    $totalBoletos = (int)$rifaActiva['total_boletos']; // Aseguramos que sea un entero
    $totalComprados = (int)$pagosRepo->getTotalBoletosByRifaId($rifaActiva['id']); // Aseguramos que sea un entero
    // if ($totalComprados !== $totalBoletos) {
    //   $error = "Aún hay boletos disponibles.";
    // }
}

$boletoGanador = $boletoRepo->findRandomVendidoByRifaId($rifaActiva['id']);

$numeroGanador = $boletoGanador['numero_boleto'];
$numeroGanadorFormateado = str_pad($numeroGanador, 4, '0', STR_PAD_LEFT);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Juega y Gana'; ?></title>

    <link rel="icon" href="<?php echo HOST; ?>assets/images/logo.ico" type="image/x-icon">

    <!-- Enlace a los archivos CSS y JS -->
    <link href="<?php echo HOST; ?>assets/css/output.css?v=<?php echo VERSION_JS; ?>" rel="stylesheet" type="text/css">
    <script href="<?php echo HOST_ADMIN; ?>assets/js/alpine.js?v=<?php echo VERSION_JS; ?>" defer></script>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>

<body class="flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.myloview.com.br/quadros/modelo-suave-azul-gradiente-de-estudio-banner-fundo-de-papel-de-parede-700-125463277.jpg')" onclick="iniciarSorteo(event)">

    <?php if ($error) { ?>
        <!-- Mostrar mensaje de error si no hay rifas activas o aún hay boletos disponibles -->
        <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow-xl mb-8 flex items-center gap-4">
                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
                <div>
                    <p class="text-center font-semibold text-xl">
                        <?php echo $error; ?> 🎟️
                    </p>
                    <p class="text-center mt-2 text-lg">
                        El sorteo no empezará hasta que no se cumplan todas las condiciones 🏆
                    </p>
                </div>
            </div>
        </section>

    <?php } else { ?>
        <!-- Contenedor principal para el sorteo -->
        <div class="w-full max-w-4xl text-center px-4">
            <img src="<?php echo HOST; ?>assets/images/logo.png" alt="Logo" class="mb-8">

            <!-- Tarjetas de números -->
            <div class="grid grid-cols-4 gap-4 mb-8" id="tarjetas">
                <?php for ($i = 1; $i <= 4; $i++) { ?>
                    <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 flex items-center justify-center h-60">
                        <div id="numero<?php echo $i; ?>" class="text-9xl font-bold text-blue-500 w-full h-full flex items-center justify-center">-</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <script>
        // Obtener el número ganador formateado desde PHP
        const numeroGanador = <?php echo json_encode($numeroGanadorFormateado); ?>;

        let yaIniciado = false;

        // Función para iniciar el sorteo
        function iniciarSorteo(event) {
            if (yaIniciado) return; // No hacer nada si ya se inició el sorteo

            yaIniciado = true; // Marcar que el sorteo ha comenzado

            const tarjetas = document.querySelectorAll('.card');
            
            // Desactivar el clic mientras se realiza el sorteo
            document.body.style.pointerEvents = 'none';

            // Convertimos el número ganador a un array de dígitos
            const numerosGanadores = numeroGanador.split('');

            // Función para animar el conteo de números en las tarjetas
            function animarConteo(tarjetaId, numeroRandom, callback) {
                const numeroElement = document.getElementById(tarjetaId);
                let conteo = 0;
                const tarjeta = numeroElement.closest('.card');
                tarjeta.style.backgroundImage = 'none'; // Eliminar imagen de fondo

                // Animación del conteo
                const intervalo = setInterval(() => {
                    if (conteo <= 9) {
                        numeroElement.textContent = conteo;
                        conteo++;
                    } else {
                        clearInterval(intervalo);
                        numeroElement.textContent = numeroRandom; // Mostrar número ganador
                        callback();
                    }
                }, 100); // Mostrar cada número por 100ms
            }

            // Función para manejar el siguiente número de tarjeta
            function iniciarSiguienteTarjeta(index) {
                if (index < 4) {
                    setTimeout(() => animarConteo(`numero${index + 1}`, numerosGanadores[index], () => iniciarSiguienteTarjeta(index + 1)), 1000);
                } else {
                  enviarNumeroGanador(numeroGanador);
                }
            }

            // Iniciar el conteo con la primera tarjeta
            iniciarSiguienteTarjeta(0);

            // Función para enviar el número ganador a PHP
            function enviarNumeroGanador(numeroGanador) {
                fetch('acciones/sorteo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ numeroGanador: numeroGanador })
                })
                .then(response => response.json())
                .then(data => {
                })
                .catch(error => {
                    console.error('Error al enviar el número ganador:', error);
                });
            }
        }
    </script>
</body>

</html>
