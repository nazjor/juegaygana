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
  <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-lg">
    <button type="button" class="absolute top-2 right-2 text-gray-400 hover:bg-gray-200 rounded-full p-2" onclick="closeModal()">
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    <h3 class="text-xl font-semibold text-gray-900 mb-4">¡Gracias por tu compra!</h3>
    <p class="text-gray-700">Has seleccionado <span id="modalTicketCount">2</span> boletos. El precio total es: <span id="modalTotalPrice">Bs. 560.0</span></p>
    <button class="mt-4 w-full bg-green-600 text-white py-3 rounded-lg" onclick="proceedWithPurchase()">Continuar</button>
  </div>
</div>

<!-- Modal for Final Purchase -->
<div id="final-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-75">
  <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-lg">
    <button type="button" class="absolute top-2 right-2 text-gray-400 hover:bg-gray-200 rounded-full p-2" onclick="closeFinalModal()">
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    <h3 class="text-xl font-semibold text-gray-900 mb-4">¡Compra exitosa!</h3>
    <p class="text-gray-700">Tu compra ha sido realizada correctamente. Nos pondremos en contacto contigo pronto.</p>
    <button class="mt-4 w-full bg-green-600 text-white py-3 rounded-lg" onclick="closeFinalModal()">Cerrar</button>
  </div>
</div>

<script src="<?php echo HOST;?>assets/js/main.js"></script>
</body>

</html>