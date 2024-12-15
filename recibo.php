<?php
$title = 'Recibo - Juega y Gana';
require_once 'admin/components/init.php';
require_once 'components/header.php';
require_once DIRPAGE_ADMIN.'util/UtilEncriptacion.php';

// Verificar si el parámetro 'codigo' está presente en la URL
if (isset($_GET['codigo'])) {
    // Obtener el valor encriptado desde la URL
    $codigoEncriptado = $_GET['codigo'];

    try {
        // Desencriptar el valor utilizando la clase UtilEncriptacion
        $codigoDesencriptado = UtilEncriptacion::desencriptar($codigoEncriptado);

        // Simulación de los datos del cliente y sus boletos (esto puede venir de una base de datos)
        $cliente = [
            'nombre' => 'Juan Pérez',
            'numero_recibo' => $codigoDesencriptado, // Este es el número del recibo
            'boletos' => [
                '1234', '5678', '9012', '3456'
            ]
        ];

    } catch (Exception $e) {
        // Si ocurre un error durante la desencriptación, mostrar un mensaje
        echo "<h1 class='text-red-600 text-center font-semibold text-xl'>Error al procesar el recibo</h1>";
        echo "<p class='text-center text-lg'>" . $e->getMessage() . "</p>";
        exit;
    }
} else {
    echo "<h1 class='text-red-600 text-center font-semibold text-xl'>Error</h1><p class='text-center text-lg'>No se ha proporcionado un código válido.</p>";
    exit;
}
?>

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">

  <!-- Recibo Section -->
  <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
    <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-4">Detalles del Recibo</h2>
    
    <!-- Información del Cliente -->
    <div class="bg-yellow-400 p-4 rounded-lg text-gray-800 mb-6">
      <div class="flex items-center gap-3">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M19 4H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM16 2v4M8 2v4M3 10h18" />
        </svg>
        <span class="font-medium text-gray-800">Cliente: <strong><?= htmlspecialchars($cliente['nombre']) ?></strong></span>
      </div>
      <div class="flex items-center gap-3 mt-4">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M5 3h14c1.1 0 1.99.9 1.99 2L21 19c0 1.1-.9 2-1.99 2H5c-1.1 0-1.99-.9-1.99-2L3 5c0-1.1.9-2 1.99-2zM12 14l4-4-4-4v3H8v2h4v3z" />
        </svg>
        <span class="font-medium text-gray-800">Número de Recibo: <strong><?= htmlspecialchars($cliente['numero_recibo']) ?></strong></span>
      </div>
    </div>

    <!-- Boleto Section -->
    <h3 class="text-xl font-semibold text-center text-gray-900 mb-4">Boletos Comprados</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
      <?php foreach ($cliente['boletos'] as $boleto): ?>
        <div class="bg-gradient-to-r from-indigo-600 via-blue-500 to-purple-600 text-white text-center p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
          <p class="text-lg font-semibold">Boleto</p>
          <p class="text-3xl font-bold"><?= htmlspecialchars($boleto) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php include_once 'components/footer.php'; ?>
