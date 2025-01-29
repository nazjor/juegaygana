<?php
session_start();
$title = 'Inicio - La Gema';
include_once 'admin/components/init.php';
include_once 'components/header.php';

iniciarSesion();

require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
require_once DIRPAGE_ADMIN . 'util/UtilFecha.php';
$rifaRepo = new RifaRepository();
$pagosRepo = new PagosRepository();
$rifaActiva = $rifaRepo->findActiveRifa();

if ($rifaActiva) {
  // Obtener el total de boletos disponibles y el total de boletos comprados
  $totalBoletos = (int)$rifaActiva['total_boletos'];
  $totalComprados = (int)$pagosRepo->getTotalBoletosByRifaId($rifaActiva['id']);
  
  // Calcular porcentaje
  $porcentaje = ($totalComprados / $totalBoletos) * 100;
  $porcentaje = round($porcentaje, 2); // Redondear a dos decimales
}
?>

<meta name="description" content="Participa en nuestras rifas y gana premios increíbles. Compra boletos y vive la emoción del sorteo. ¡La Gema!">
<meta name="keywords" content="rifas, premios, boletos, sorteos, ganar, participar, juegos, sorteos online">
<meta name="author" content="La Gema">
<meta property="og:title" content="La Gema - Participa en rifas y gana premios">
<meta property="og:description" content="Participa en nuestras rifas y gana premios increíbles. Compra boletos y vive la emoción del sorteo. ¡La Gema!">
<meta property="og:image" content="<?php echo HOST;?>assets/images/logo.png">
<meta property="og:url" content="<?php echo HOST;?>">
<meta name="twitter:title" content="La Gema - Participa en rifas y gana premios">
<meta name="twitter:description" content="Participa en nuestras rifas y gana premios increíbles. Compra boletos y vive la emoción del sorteo. ¡La Gema!">
<meta name="twitter:image" content="<?php echo HOST;?>assets/images/logo.png">
<meta name="twitter:card" content="summary_large_image">
<title><?php echo $title ?? 'La Gema'; ?></title>

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">

  <?php if (!$rifaActiva): ?>
    <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
      <!-- Mostrar mensaje amigable si no hay rifas activas -->
      <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow-xl mb-8 flex items-center gap-4">
        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
        </svg>
        <div>
          <p class="text-center font-semibold text-xl">
            ¡No hay rifas activas en este momento! 🎟️
          </p>
          <p class="text-center mt-2 text-lg">
            Estamos preparando nuevas sorpresas para ti. Vuelve pronto para participar y ganar increíbles premios. 🏆
          </p>
        </div>
      </div>
    </section>

  <?php else: ?>

  <!-- Details Section -->
  <section class="bg-primary rounded-lg p-6 mb-6 shadow-lg">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
      <!-- Información del Sorteo -->
      <div class="flex items-center gap-3 bg-alert p-2 rounded-lg">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M19 4H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM16 2v4M8 2v4M3 10h18" />
        </svg>
          <span class="font-medium">
            <?php echo UtilFecha::formatearFecha($rifaActiva['fecha_inicio']); ?>
          </span>
      </div>

      <!-- Precio del Boleto -->
      <div class="text-center sm:text-right mt-4 sm:mt-0">
        <p class="text-sm text-white">Precio del boleto</p>
        <p class="text-xl font-bold text-white">Bs. <?php echo($rifaActiva['precio_boleto'])?></p>
      </div>
    </div>

    <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">¡Gana un <strong> <?php echo($rifaActiva['titulo'])?> </strong>!</h1>
  </section>

  <!-- New Image Section -->
  <section class="relative rounded-xl overflow-hidden mb-6">
    <img src="<?php echo HOST_ADMIN.'assets/'.$rifaActiva['imagen_rifa']?>" alt="Imagen de promoción" class="w-full object-cover rounded-lg shadow-lg">
  </section>

  <!-- Progress Bar -->
  <section class="bg-white rounded-xl p-4 mb-6 shadow-lg">
    <div class="w-full bg-primary rounded-full h-4 relative">
      <div class="absolute inset-0 flex justify-center items-center">
        <span class="text-xs font-medium text-white">Progreso: <?= $porcentaje ?>%</span>
      </div>
      <div class="bg-secundary h-4 rounded-full" style="width: <?= $porcentaje ?>%;"></div>
    </div>
  </section>


  <!-- Ticket Purchase Section -->
  <section class="bg-white rounded-xl p-6 mb-6 shadow-lg">
    <h3 class="text-xl font-semibold text-center mb-4 text-gray-900">¡Elige la cantidad de boletos!</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-4">
      <button class="bg-primary text-white px-8 py-4 rounded-lg text-xl" onclick="updateTicketCount(2)">🎫 2</button>
      <button class="bg-secundary text-white px-8 py-4 rounded-lg text-xl" onclick="updateTicketCount(5)">🎉 5 <span class="text-md lg:text-xl block text-white">¡Recomendado!</span></button>
      <button class="bg-primary text-white px-8 py-4 rounded-lg text-xl" onclick="updateTicketCount(10)">🎫 10</button>
    </div>

    <!-- Ticket Quantity Adjustment -->
    <div class="flex justify-center items-center gap-4 mb-4">
      <button id="decreaseBtn" class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600" disabled>-</button>
      <span id="ticketCount" class="text-2xl font-bold">2</span>
      <button id="increaseBtn" class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600">+</button>
    </div>

    <!-- Purchase Button -->
    <div class="flex justify-center">
      <button class="bg-primary text-white px-6 py-3 rounded-full shadow-lg hover:bg-green-700 font-semibold text-lg" id="purchaseBtn">
        ¡Compra tu boleto ahora!
      </button>
    </div>
  </section>

  <?php if ($rifaActiva["descripcion"]) { ?>
    <section class="bg-white rounded-lg p-6 mb-6 shadow-lg text-lg sm:text-xl" style="white-space: pre-line;">
      <h2 class="text-xl sm:text-2xl font-bold text-gray-900"><strong> Detalles de la rifa: </strong></h2>
      <hr>
      <?php echo ($rifaActiva["descripcion"]); ?>
    </section>
  <?php } ?>
</main>

<script>
   // Obtener el precio del boleto desde PHP
   const pricePerTicket = <?php echo $rifaActiva['precio_boleto']; ?>;
</script>


<!-- Modal for Confirmation -->
<div id="static-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-xl transition-transform transform scale-95 hover:scale-100">
    <!-- Close Button -->
    <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 rounded-full p-2 transition duration-200" onclick="closeModal()">
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    
    <!-- Modal Header -->
    <h3 class="text-2xl font-semibold text-gray-900 mb-4 text-center">¡Estás a punto de hacer tu compra!</h3>
    
    <!-- Modal Body -->
    <p class="text-primary text-center text-lg mb-6">Has seleccionado <span id="modalTicketCount" class="font-bold text-primary">2</span> boletos. <br> El precio total es: <span id="modalTotalPrice" class="font-bold text-primary">Bs. 560.0</span></p>

    <!-- Modal Footer -->
    <button class="mt-4 w-full bg-primary text-white py-3 rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200" onclick="proceedWithPurchase()">¡Comprar ahora!</button>
  </div>
</div>

<!-- Modal for Final Purchase -->
<div id="final-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-auto max-h-[95vh]">
    <button type="button" class="absolute top-2 right-2 text-gray-400 hover:bg-gray-200 rounded-full p-2" onclick="closeFinalModal()">
      <i class="ri-close-line w-6 h-6"></i> <!-- Icono de cerrar (Remix Icon) -->
    </button>

    <h3 class="text-2xl font-semibold text-gray-900 mb-4 text-center">Realizar Compra</h3>

    <p class="text-gray-700 mb-4 text-center">Por favor, completa los detalles para procesar tu compra.</p>

    <!-- Formulario para recoger datos -->
    <form id="purchase-form" method="POST" enctype="multipart/form-data" class="space-y-5">
      <!-- Nombre y Apellido en 6 columnas -->
      <div class="grid grid-cols-6 gap-4 mb-4">
        <div class="col-span-3">
          <div class="flex items-center space-x-2">
            <i class="ri-user-line text-gray-500 w-6 h-6"></i> <!-- Icono de usuario -->
            <input type="text" id="first-name" name="first-name" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Nombre" required />
          </div>
        </div>
        <div class="col-span-3">
          <div class="flex items-center space-x-2">
            <i class="ri-user-line text-gray-500 w-6 h-6"></i> <!-- Icono de usuario -->
            <input type="text" id="last-name" name="last-name" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Apellido" required />
          </div>
        </div>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <div class="flex items-center space-x-2">
          <i class="ri-mail-line text-gray-500 w-6 h-6"></i> <!-- Icono de correo -->
          <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Correo Electrónico" required />
        </div>
      </div>

      <!-- Cédula y Teléfono en 6 columnas -->
      <div class="grid grid-cols-6 gap-4 mb-4">
        <div class="col-span-3">
          <div class="flex items-center space-x-2">
            <i class="ri-file-text-line text-gray-500 w-6 h-6"></i> <!-- Icono de cédula -->
            <input type="text" id="cedula" name="cedula" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Cédula" required />
          </div>
        </div>
        <div class="col-span-3">
          <div class="flex items-center space-x-2">
            <i class="ri-phone-line text-gray-500 w-6 h-6"></i> <!-- Icono de teléfono -->
            <input type="tel" id="phone" name="phone" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Teléfono" required />
          </div>
        </div>
      </div>

      <!-- Dirección -->
      <div class="mb-4">
        <div class="flex items-center space-x-2">
          <i class="ri-map-pin-line text-gray-500 w-6 h-6"></i> <!-- Icono de ubicación -->
          <input type="text" id="address" name="address" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Barquisimeto" required />
        </div>
      </div>

      <!-- Foto -->
      <div class="mb-4">
        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">Sube la imagen del pago (Solo JPG, JPEG y PNG):</label>
        <div class="flex items-center space-x-2">
          <i class="ri-camera-line text-gray-500 w-6 h-6"></i> <!-- Icono de cámara -->
          <input type="file" id="photo" name="photo" class="w-full border border-gray-300 rounded-lg p-2" accept=".jpg, .jpeg, .png" required />
        </div>
      </div>

      <!-- Información de pago -->
      <div class="bg-gray-100 p-4 rounded-lg mb-4">
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Datos de Pago</h4>
        <p class="text-sm text-gray-700">Por favor, realiza el pago a la siguiente cuenta bancaria:</p>
        <ul class="list-disc pl-5 mt-2">
          <li><strong>Banco:</strong> El Tesoro</li>
          <li><strong>Número de teléfono:</strong> 0424-5396921</li>
          <li><strong>Cédula del titular:</strong> 11.428.586</li>
        </ul>
      </div>

      <!-- Botón de Enviar -->
      <button id="botonComprarTique" type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">Confirmar Compra</button>
    </form>
  </div>
</div>

<?php endif; ?>

<!-- Modal de éxito -->
<div id="success-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-lg overflow-auto max-h-[95vh]">
    <h3 class="text-2xl font-semibold text-gray-900 mb-4 text-center">Compra Realizada</h3>
    <p class="text-gray-700 mb-4 text-center">¡Gracias por tu compra! Una vez confirmado el pago, se enviarán tus boletos.</p>
    <button type="button" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200" onclick="closeSuccessModal()">Cerrar</button>
  </div>
</div>

<!-- Modal de Términos y Condiciones -->
<div id="terms-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-lg bg-white rounded-lg shadow-lg overflow-auto max-h-[95vh]">
    <h3 class="text-2xl font-semibold text-gray-900 mb-4 text-center">Términos y Condiciones</h3>
    <p class="text-gray-700 text-sm mb-4">
      Bienvenido a <strong>La Gema</strong>. Por favor, lea cuidadosamente nuestros términos y condiciones antes de participar en nuestras rifas:
    </p>
    <ul class="text-gray-700 text-sm list-disc pl-5 mb-4 space-y-2">
      <li>El sorteo se realiza una vez se haya vendido el 100% de los boletos.</li>
      <li>Los números para cada rifa se asignan de manera aleatoria y se detallan en tu recibo.</li>
      <li>Solo pueden participar personas mayores de 18 años, con nacionalidad venezolana o extranjeros residentes en Venezuela.</li>
      <li>Los sorteos se realizan en vivo a través de nuestras plataformas oficiales. Asegúrate de seguirnos para no perderte la transmisión.</li>
      <li>La confirmación del pago puede tardar entre 1 y 8 horas. Te notificaremos una vez que esté aprobado.</li>
      <li>Los ganadores aceptan que <strong>La Gema</strong> pueda publicar fotos y videos de la entrega de premios en sus redes sociales.</li>
      <li>Es responsabilidad del participante asegurarse de que sus datos sean correctos al momento de registrarse.</li>
      <li>No se permiten reembolsos una vez que los números hayan sido asignados.</li>
      <li>Al aceptar estos términos, confirma que entiende y está de acuerdo con todas las condiciones descritas.</li>
    </ul>
    <button 
      id="accept-terms-btn" 
      type="button" 
      class="w-full bg-primary text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">
      Aceptar Términos y Condiciones
    </button>
  </div>
</div>

<script src="<?php echo HOST;?>assets/js/index.js?v1=<?php echo VERSION_JS;?>"></script>

<?php include_once 'components/footer.php'; ?>