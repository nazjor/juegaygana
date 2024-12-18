<?php 

require __DIR__.'../../conf/config.php';
require_once DIRPAGE_ADMIN.'components/init.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Juega y Gana'; ?></title>

  <link href="<?php echo HOST;?>assets/css/output.css?v=<?php echo VERSION_JS;?>" rel="stylesheet" type="text/css">
  <link>
  <script href="<?php echo HOST_ADMIN;?>assets/js/alpine.js?v=<?php echo VERSION_JS;?>" defer></script>
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

  <!-- Contenedor principal -->
  <div class="w-full max-w-4xl text-center px-4">    
    <!-- Logo arriba de las tarjetas -->
    <img src="<?php echo HOST;?>assets/images/logo.png" alt="Logo" class="mb-8">

    <!-- Tarjetas de números -->
    <div class="grid grid-cols-4 gap-4 mb-8" id="tarjetas">
      <!-- Tarjetas visibles con borde azul y fondo blanco -->
      <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 flex items-center justify-center h-60">
        <div id="numero1" class="text-9xl font-bold text-blue-500 w-full h-full flex items-center justify-center">-</div>
      </div>
      <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 flex items-center justify-center h-60">
        <div id="numero2" class="text-9xl font-bold text-blue-500 w-full h-full flex items-center justify-center">-</div>
      </div>
      <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 flex items-center justify-center h-60">
        <div id="numero3" class="text-9xl font-bold text-blue-500 w-full h-full flex items-center justify-center">-</div>
      </div>
      <div class="card bg-white border-4 border-blue-500 rounded-lg p-8 flex items-center justify-center h-60">
        <div id="numero4" class="text-9xl font-bold text-blue-500 w-full h-full flex items-center justify-center">-</div>
      </div>
    </div>
  </div>

  <script>
    let yaIniciado = false;

    // Función que se llama cuando se hace clic en cualquier parte del body
    function iniciarSorteo(event) {
      if (yaIniciado) return; // No hacer nada si ya se inició el sorteo

      yaIniciado = true; // Marcar que el sorteo ha comenzado

      const tarjetas = document.querySelectorAll('.card');
      
      // Desactivar el clic mientras se realiza el sorteo
      document.body.style.pointerEvents = 'none';

      // Números a mostrar en las tarjetas (4 dígitos aleatorios)
      const numeros = Array.from({ length: 4 }, () => Math.floor(Math.random() * 9).toString().padStart(1, '0'));

      // Almacenar los resultados de las tarjetas
      const resultados = [];

      // Función para realizar la animación del conteo de 0 al 9
      function animarConteo(tarjetaId, numeroRandom, callback) {
        const numeroElement = document.getElementById(tarjetaId);
        let conteo = 0;

        // Eliminar la imagen de fondo al empezar el conteo
        const tarjeta = numeroElement.closest('.card');
        tarjeta.style.backgroundImage = 'none';

        // Animación del conteo
        const intervalo = setInterval(() => {
          if (conteo <= 9) {
            numeroElement.textContent = conteo;
            conteo++;
          } else {
            clearInterval(intervalo);  // Detener el conteo
            numeroElement.textContent = numeroRandom; // Mostrar el número aleatorio
            resultados.push(numeroRandom);  // Guardar el resultado
            callback();  // Llamar al siguiente paso
          }
        }, 100); // Mostrar cada número por 100ms (del 0 al 9)
      }

      // Función para iniciar la animación de la siguiente tarjeta
      function iniciarSiguienteTarjeta(index) {
        if (index < 4) {
          setTimeout(() => animarConteo(`numero${index + 1}`, numeros[index], () => iniciarSiguienteTarjeta(index + 1)), 1000);
        } else {
          // Después de todas las tarjetas, mostrar el resultado final en la consola
          console.log('Resultados finales:', resultados);
          setTimeout(() => {
            document.body.style.pointerEvents = 'auto'; // Rehabilitar el clic
          }, 1000);  // 1 segundo para finalizar
        }
      }

      // Iniciar la animación con la primera tarjeta
      iniciarSiguienteTarjeta(0);
    }
  </script>
</body>
</html>
