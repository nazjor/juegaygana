<?php
// Incluir archivos de configuración y bibliotecas
require __DIR__ . '../../conf/config.php';
require_once DIRPAGE_ADMIN . 'components/init.php';

// Iniciar sesión y validar autenticación
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$numerosGanadoresFormateados[0] = "1010";
$numerosGanadoresFormateados[1] = "2100";
$numerosGanadoresFormateados[2] = "3001";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'La Gema'; ?></title>
    <link rel="icon" href="<?php echo HOST; ?>assets/images/logo.ico" type="image/x-icon">
    <script href="<?php echo HOST_ADMIN; ?>assets/js/alpine.js?v=<?php echo VERSION_JS; ?>" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .card {
            background-size: 300px;
            background-position: center;
        }

        #card1 {
            background-image: url('https://juegayganaconmanolo.com/admin/assets/images/premio1.png');
        }

        #card2 {
            background-image: url('https://juegayganaconmanolo.com/admin/assets/images/premio2.png');
        }

        #card3 {
            background-image: url('https://juegayganaconmanolo.com/admin/assets/images/premio3.png');
        }

        .no-bg {
            background-image: none !important;
        }

        .hidden {
            visibility: hidden;
        }

        .floating-label {
            position: absolute;
            top: -28px;
            left: 50%;
            transform: translateX(-35%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            z-index: 10;
            scale: 1.4;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .floating-label.first-prize {
            top: -55px;
            /* Ajusta más arriba */
        }
    </style>
</head>

<body class="flex items-center justify-center bg-cover bg-center"
    style="background: rgb(0, 42, 65)" onclick="handleBodyClick()">

    <div class="flex flex-col items-center">
        <h1 style="background-color: red; padding: 0px 20px; color:white;">Simulación</h1>
        <img src="<?php echo HOST; ?>assets/images/logo.png" height="220px" alt="Logo" class="mb-12 mt-8" style="height: 220px;">

        <div class="flex justify-center gap-6 relative mt-12">

            <div class="card-container relative">
                <div class="floating-label">Segundo premio</div>
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center" id="card2">
                    <p class="text-8xl font-bold  hidden" id="numero2">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>
            </div>

            <div class="card-container relative">
                <div class="floating-label first-prize">Primer premio</div>
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center transform -translate-y-8" id="card1">
                    <p class="text-8xl font-bold  hidden" id="numero1">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>
            </div>

            <div class="card-container relative">
                <div class="floating-label">Tercer premio</div>
                <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 w-96 h-60 flex items-center justify-center" id="card3">
                    <p class="text-8xl font-bold  hidden" id="numero3">
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                        <span>-</span>
                    </p>
                </div>
            </div>

        </div>

    </div>
    <audio id="sonidoBolas" src="https://juegayganaconmanolo.com/assets/resources/bolas.mp3"></audio>

    <script>
        let clickCount = 0;
        let animacionEnCurso = false; // Control de animación en curso
        const numerosGanadores = ["<?php echo $numerosGanadoresFormateados[2]; ?>", "<?php echo $numerosGanadoresFormateados[1]; ?>", "<?php echo $numerosGanadoresFormateados[0]; ?>"];

        function handleBodyClick() {
            if (clickCount < 3 && !animacionEnCurso) { // Verifica si no hay animación en curso

                const tarjetaId = `card${3 - clickCount}`; // Identifica la tarjeta que se está procesando
                const numeroId = `numero${3 - clickCount}`;

                // Ocultar el fondo de la tarjeta actual
                const tarjetaActual = document.getElementById(tarjetaId);
                tarjetaActual.classList.add('no-bg');

                // Mostrar el <p> con los números
                const tarjetaConSpan = document.getElementById(numeroId);
                tarjetaConSpan.classList.remove('hidden');


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
            animacionEnCurso = true; // Marca que la animación ha comenzado

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
                    } else if (index === 3) { // Al finalizar la animación del último dígito
                        animacionEnCurso = false; // Marca que la animación ha terminado
                    }
                }, 1500);
            }

            animarDigito(currentIndex);
        }

        function enviarNumeroGanador(numerosGanadores) {
            console.log("simulado correctamente");
            console.log(numerosGanadores);
        }
    </script>

</body>

</html>