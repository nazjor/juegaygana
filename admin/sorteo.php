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
$numerosGanadoresFormateados = [];
while (count($numerosGanadores) < 3) {
    $numeroAleatorio = $boletoRepo->findRandomVendidoByRifaId($rifaActiva['id']);
    if(!$numeroAleatorio) continue;
    if (!in_array($numeroAleatorio, $numerosGanadores)) {
        $numerosGanadores[] = $numeroAleatorio['numero_boleto'];
    }
}

// Verificar disponibilidad de boletos
if ($error == null) {
    $totalBoletos = (int)$rifaActiva['total_boletos']; // Aseguramos que sea un entero
    $totalComprados = (int)$pagosRepo->getTotalBoletosByRifaId($rifaActiva['id']); // Aseguramos que sea un entero
    if ($totalComprados !== $totalBoletos) {
    //   $error = "Aún hay boletos disponibles.";
    }

    if(count($numerosGanadores) < 3) {
        $error = $rifaActiva ? null : "¡No hay boletos suficientes!";
    } else {
        // Formatear los números ganadores a 4 dígitos (agregar ceros si es necesario)
        $numerosGanadoresFormateados = array_map(function ($numero) {
            return str_pad($numero, 4, '0', STR_PAD_LEFT);
        }, $numerosGanadores);
    }
}
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

<body class="flex items-center justify-center bg-cover bg-center" 
      style="background: linear-gradient(to right,rgb(80, 191, 255), #ffffff,rgb(80, 150, 255));" onclick="handleBodyClick()">

    <div class="flex flex-col items-center">
        <img src="<?php echo HOST; ?>assets/images/logo.png" alt="Logo" class="mb-8 h-64">

        <?php if ($error) { ?>
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
            <div class="flex justify-center gap-6 relative mt-12">

                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center">
                    <p class="text-8xl font-bold text-blue-500" id="numero2">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>
              
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center transform -translate-y-8" id="card2">
                    <p class="text-8xl font-bold text-blue-500" id="numero1">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>

                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center" id="card3">
                    <p class="text-8xl font-bold text-blue-500" id="numero3">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
    <audio id="sonidoBolas" src="https://juegayganaconmanolo.com/assets/resources/bolas.mp3"></audio>

    <script>
        let clickCount = 0;
        const numerosGanadores = ["<?php echo $numerosGanadoresFormateados[2]; ?>", "<?php echo $numerosGanadoresFormateados[1]; ?>", "<?php echo $numerosGanadoresFormateados[0]; ?>"];

        function handleBodyClick() {
            if (clickCount < 3) {
                const targetCard = `card${3 - clickCount}`;
                const numeroId = `numero${3 - clickCount}`;
                animarConteo(numeroId, numerosGanadores[clickCount]);
                clickCount++;

                if (clickCount === 3) {
                    setTimeout(() => {
                        enviarNumeroGanador(numerosGanadores);
                    }, 3000);
                }
            }
        }

        function animarConteo(tarjetaId, numeroRandom) {
            const numeroElement = document.getElementById(tarjetaId);
            const digitos = numeroElement.querySelectorAll('span');
            const sonido = document.getElementById('sonidoBolas');

            let numeroArray = numeroRandom.split('');
            let currentIndex = 0;

            function animarDigito(index) {
                let intervaloAleatorio;
                sonido.play();

                intervaloAleatorio = setInterval(() => {
                    digitos[index].textContent = Math.floor(Math.random() * 10);
                }, 100);

                setTimeout(() => {
                    clearInterval(intervaloAleatorio);
                    digitos[index].textContent = numeroArray[index];
                    sonido.pause();
                    sonido.currentTime = 0;

                    if (index < 3) {
                        setTimeout(() => {
                            animarDigito(index + 1);
                        }, 500);
                    }
                }, 1500);
            }

            animarDigito(currentIndex);
        }

        function enviarNumeroGanador(numerosGanadores) {
            fetch('acciones/sorteo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ numerosGanadores })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Números enviados:', data);
            })
            .catch(error => {
                console.error('Error al enviar los números ganadores:', error);
            });
        }
    </script>

</body>

</html>
