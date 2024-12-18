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
}

// Obtener tres números ganadores aleatorios, sin repeticiones
$numerosGanadores = [];
while (count($numerosGanadores) < 3) {
    $numeroAleatorio = rand(1, $totalBoletos); // Generamos un número aleatorio
    if (!in_array($numeroAleatorio, $numerosGanadores)) {
        $numerosGanadores[] = $numeroAleatorio; // Añadimos el número si no está en el array
    }
}

// Formatear los números ganadores a 4 dígitos (agregar ceros si es necesario)
$numerosGanadoresFormateados = array_map(function($numero) {
    return str_pad($numero, 4, '0', STR_PAD_LEFT);
}, $numerosGanadores);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Juega y Gana'; ?></title>
    <link rel="icon" href="<?php echo HOST; ?>assets/images/logo.ico" type="image/x-icon">
    <script href="<?php echo HOST_ADMIN; ?>assets/js/alpine.js?v=<?php echo VERSION_JS; ?>" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center bg-cover bg-center" style="background: linear-gradient(to right,rgb(80, 191, 255), #ffffff,rgb(80, 150, 255));">

    <div class="flex flex-col items-center">
        <img src="<?php echo HOST; ?>assets/images/logo.png" alt="Logo" class="mb-8 h-64">

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

            <!-- Contenedor de las tarjetas de premios -->
            <div class="flex justify-center gap-6 relative mt-12">
                <!-- Premio 1 a la izquierda -->
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center" onclick="animarConteo('numero1', '<?php echo $numerosGanadoresFormateados[0]; ?>')">

                    <p class="text-8xl font-bold text-blue-500" id="numero1">
                        <span id="1num1">-</span>
                        <span id="1num2">-</span>
                        <span id="1num3">-</span>
                        <span id="1num4">-</span>
                    </p>
                </div>
                <!-- Tarjeta central con el premio 2 (movida hacia arriba) -->
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center transform -translate-y-8" onclick="animarConteo('numero2', '<?php echo $numerosGanadoresFormateados[1]; ?>')">
                    <p class="text-8xl font-bold text-blue-500" id="numero2">
                        <span id="2num1">-</span>
                        <span id="2num2">-</span>
                        <span id="2num3">-</span>
                        <span id="2num4">-</span>
                    </p>
                </div>

                <!-- Premio 3 a la derecha -->
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center" onclick="animarConteo('numero3', '<?php echo $numerosGanadoresFormateados[2]; ?>')">
                    <p class="text-8xl font-bold text-blue-500" id="numero3">
                        <span id="3num1">-</span>
                        <span id="3num2">-</span>
                        <span id="3num3">-</span>
                        <span id="3num4">-</span>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
    <audio id="sonidoBolas" src="https://juegayganaconmanolo.com/assets/resources/bolas.mp3"></audio>
<script>
    // Función para animar el conteo de números en las tarjetas
    function animarConteo(tarjetaId, numeroRandom) {
        const numeroElement = document.getElementById(tarjetaId);
        const digitos = numeroElement.querySelectorAll('span'); // Obtener todos los elementos <span> de cada dígito

        // Reproducir el sonido y mantenerlo mientras se animan los números
        const sonido = document.getElementById('sonidoBolas');

        let numeroConCeros = numeroRandom.padStart(4, '0');
        let numeroArray = numeroConCeros.split('');
        
        let currentIndex = 0; // Índice para controlar el ciclo de 4 dígitos

        // Función para animar un dígito
        function animarDigito(index) {
            let intervaloAleatorio;
            let currentNumber = [0, 0, 0, 0]; // Inicializamos los números en 0 para cada dígito

            // Reproducir el sonido para el dígito actual
            sonido.play();
            
            // Intervalo de animación para el dígito actual
            intervaloAleatorio = setInterval(() => {
                currentNumber[index] = Math.floor(Math.random() * 10); // Asignar un número aleatorio de 0 a 9
                digitos[index].textContent = currentNumber[index]; // Asignar el nuevo número al <span>
            }, 100); // Intervalo de 200ms entre cada cambio de número (más lento)

            // Después de 2 segundos, detener la animación y mostrar el número final
            setTimeout(() => {
                clearInterval(intervaloAleatorio); // Detener la animación para este dígito
                digitos[index].textContent = numeroArray[index]; // Mostrar el número final
                sonido.pause(); // Detener el sonido
                sonido.currentTime = 0; // Reiniciar el tiempo del audio a 0

                // Si hemos terminado el ciclo de un dígito, esperar 1 segundo y luego continuar
                if (index < 3) {
                    setTimeout(() => {
                        animarDigito(index + 1); // Llamar recursivamente para el siguiente dígito
                    }, 1000); // Esperar 1 segundo entre cada dígito
                }
            }, 2000); // Duración de la animación = 2 segundos (igual que el audio)
        }

        // Iniciar la animación para el primer dígito
        animarDigito(currentIndex);
    }
</script>


</body>

</html>
