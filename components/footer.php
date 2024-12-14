<!-- Footer -->
<footer class="bg-white text-gray-800 py-6 mt-auto shadow-lg">
  <div class="container mx-auto text-center">
    <p class="text-sm">Síguenos en nuestras redes:</p>
    <div class="flex justify-center gap-4 mt-2">
      <a href="https://www.instagram.com" class="text-gray-800 hover:text-green-600">
        <span class="material-icons">instagram</span>
      </a>
      <a href="https://www.facebook.com" class="text-gray-800 hover:text-green-600">
        <span class="material-icons">facebook</span>
      </a>
    </div>
    <!-- Derechos reservados -->
    <p class="text-xs mt-4 mb-4">&copy; 2024 Juega y Gana con Manolo. Todos los derechos reservados.</p>
  </div>
</footer>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/584245396921" class="fixed bottom-6 right-6 bg-teal-600 text-white p-4 rounded-full shadow-xl hover:bg-teal-700 transition">
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/800px-WhatsApp.svg.png" alt="WhatsApp" class="w-10 h-10">
</a>
</div>

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
    <form id="purchase-form" action="/path/to/your/server/endpoint" method="POST" enctype="multipart/form-data" class="space-y-5">

      <!-- Foto -->
      <div class="mb-4">
        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2 hidden">Sube una foto:</label>
        <div class="flex items-center space-x-2">
          <i class="ri-camera-line text-gray-500 w-6 h-6"></i> <!-- Icono de cámara -->
          <input type="file" id="photo" name="photo" class="w-full border border-gray-300 rounded-lg p-2" required />
        </div>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <div class="flex items-center space-x-2">
          <i class="ri-mail-line text-gray-500 w-6 h-6"></i> <!-- Icono de correo -->
          <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Correo Electrónico" required />
        </div>
      </div>

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
          <input type="text" id="address" name="address" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Dirección" required />
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

<script src="<?php echo HOST;?>assets/js/main.js?v1=<?php echo VERSION_JS;?>"></script>
</body>

</html>