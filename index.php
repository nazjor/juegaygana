<?php
$title = 'Inicio - Juega y Gana';
include_once 'components/header.php';
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
        <span class="font-medium text-gray-800">Sorteo: 26 de Noviembre, 2024</span>
      </div>

      <!-- Precio del Boleto -->
      <div class="text-center sm:text-right mt-4 sm:mt-0">
        <p class="text-sm text-gray-600">Precio del boleto</p>
        <p class="text-xl font-bold">Bs. 280,0</p>
      </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900">¡Gana un <strong>CHEVROLET AVEO 2025</strong>!</h2>
  </section>

  <!-- New Image Section -->
  <section class="relative rounded-xl overflow-hidden mb-6">
    <img src="https://es.abc-aluminum.com/wp-content/uploads/2021/02/DSC1194-2048x1271.jpeg" alt="Imagen de promoción" class="w-full h-72 object-cover rounded-lg shadow-lg">
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

<?php include_once 'components/footer.php'; ?>