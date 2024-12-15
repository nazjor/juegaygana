<?php
$title = 'Inicio - Juega y Gana';
include_once 'admin/components/init.php';
include_once 'components/header.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
$rifaRepo = new RifaRepository();
$rifaActiva = $rifaRepo->findActiveRifa();
?>

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">

  <!-- Details Section -->
  <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
      <!-- Información del Sorteo -->
      <div class="flex items-center gap-3 bg-yellow-400 p-2 rounded-lg text-gray-800">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M19 4H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM16 2v4M8 2v4M3 10h18" />
        </svg>

        <?php
          $meses = [
              1 => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio',
              '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
          ];
          ?>

          <span class="font-medium text-gray-800">Sorteo: <?php 
              // Suponiendo que 'fecha_inicio' es un string con formato YYYY-MM-DD
              $fecha = new DateTime($rifaActiva['fecha_inicio']);
              $dia = $fecha->format('d');
              $mes = $meses[(int)$fecha->format('m')];
              $año = $fecha->format('Y');
              echo "$dia de $mes, $año";
          ?></span>
      </div>

      <!-- Precio del Boleto -->
      <div class="text-center sm:text-right mt-4 sm:mt-0">
        <p class="text-sm text-gray-600">Precio del boleto</p>
        <p class="text-xl font-bold">Bs. <?php echo($rifaActiva['precio_boleto'])?></p>
      </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900">¡Gana un <strong> <?php echo($rifaActiva['titulo'])?> </strong>!</h2>
  </section>

  <!-- New Image Section -->
  <section class="relative rounded-xl overflow-hidden mb-6">
    <img src="<?php echo HOST_ADMIN.'assets/'.$rifaActiva['imagen_rifa']?>" alt="Imagen de promoción" class="w-full h-72 object-cover rounded-lg shadow-lg">
  </section>

  <!-- Progress Bar -->
  <section class="bg-white rounded-xl p-4 mb-6 shadow-lg">
    <div class="w-full bg-green-500 rounded-full h-4 relative">
      <div class="absolute inset-0 flex justify-center items-center">
        <span class="text-xs font-medium text-white">Progreso: 45.50%</span>
      </div>
      <div class="bg-green-800 h-4 rounded-full" style="width: 45.50%;"></div>
    </div>
  </section>

  <!-- Ticket Purchase Section -->
  <section class="bg-white rounded-xl p-6 mb-6 shadow-lg">
    <h3 class="text-xl font-semibold text-center mb-4 text-gray-900">¡Elige la cantidad de boletos!</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-4">
      <button class="bg-green-500 text-white px-8 py-4 rounded-lg hover:bg-green-600 text-xl" onclick="updateTicketCount(2)">🎫 2</button>
      <button class="bg-green-600 text-white px-8 py-4 rounded-lg hover:bg-green-700 text-xl" onclick="updateTicketCount(5)">🎉 5 <span class="text-xs block text-gray-300">¡Recomendado!</span></button>
      <button class="bg-green-500 text-white px-8 py-4 rounded-lg hover:bg-green-600 text-xl" onclick="updateTicketCount(10)">🎫 10</button>
    </div>

    <!-- Ticket Quantity Adjustment -->
    <div class="flex justify-center items-center gap-4 mb-4">
      <button id="decreaseBtn" class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600" disabled>-</button>
      <span id="ticketCount" class="text-2xl font-bold">2</span>
      <button id="increaseBtn" class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600">+</button>
    </div>

    <!-- Purchase Button -->
    <div class="flex justify-center">
      <button class="bg-green-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-green-700 font-semibold text-lg" id="purchaseBtn">
        ¡Compra tu boleto ahora!
      </button>
    </div>
  </section>
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
    <p class="text-gray-700 text-center text-lg mb-6">Has seleccionado <span id="modalTicketCount" class="font-bold text-green-600">2</span> boletos. <br> El precio total es: <span id="modalTotalPrice" class="font-bold text-green-600">Bs. 560.0</span></p>

    <!-- Modal Footer -->
    <button class="mt-4 w-full bg-green-600 text-white py-3 rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200" onclick="proceedWithPurchase()">¡Comprar ahora!</button>
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
      <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">Confirmar Compra</button>
    </form>
  </div>
</div>

<!-- Modal de éxito -->
<div id="success-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-lg overflow-auto max-h-[95vh]">
    <h3 class="text-2xl font-semibold text-gray-900 mb-4 text-center">Compra Realizada</h3>
    <p class="text-gray-700 mb-4 text-center">¡Gracias por tu compra! Una vez confirmado el pago, se enviarán tus boletos.</p>
    <button type="button" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200" onclick="closeSuccessModal()">Cerrar</button>
  </div>
</div>

<script src="<?php echo HOST;?>assets/js/main.js?v1=<?php echo VERSION_JS;?>"></script>

<?php include_once 'components/footer.php'; ?>