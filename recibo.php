<?php
$title = 'Recibo - Juega y Gana';
require_once 'admin/components/init.php';
require_once DIRPAGE.'components/header.php';
require_once DIRPAGE_ADMIN . 'repositories/BoletosRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
require_once DIRPAGE_ADMIN.'util/UtilEncriptacion.php';

// Verificar si el parámetro 'codigo' está presente en la URL
if (isset($_GET['codigo'])) {
    // Obtener el valor encriptado desde la URL
    $codigoEncriptado = $_GET['codigo'] ?? "";

    try {
        // Desencriptar el valor utilizando la clase UtilEncriptacion
        $codigoDesencriptado = UtilEncriptacion::desencriptar($codigoEncriptado);

        $idPago = (int) $codigoDesencriptado;

        $boletosRepo = new BoletosRepository();
        $clienteRepo = new ClientesRepository();
        $pagoRepo = new PagosRepository();

        $pagoExistente = $pagoRepo->findPagoById($idPago);
        if (!$pagoExistente) {
          throw new Exception("El pago no existe.");
        }

        $numeroRecibo = str_pad($pagoExistente['id'], 8, '0', STR_PAD_LEFT);

        $clienteRecord = $clienteRepo->findClienteById($pagoExistente['cliente_id']);

        if (!$clienteRecord) {
            throw new Exception("El cliente no existe.");
        }

        $boletosRecord = $boletosRepo->findByPagoId($pagoExistente['id']);

        $boletos = array_map(function($item) {
            return $item['numero_boleto'];
        }, $boletosRecord);
        
        $cliente = [
          'nombre' => $clienteRecord['nombre'] . " " . $clienteRecord['apellido'],
          'cedula' => $clienteRecord['cedula'],
          'numero_recibo' => $numeroRecibo,
          'boletos' => $boletos
        ];

    } catch (Exception $e) {
        // Si ocurre un error durante la desencriptación, $cliente quedará vacío
        $cliente = null;
    }
} else {
    $cliente = null;
}
?>

<!-- Meta SEO -->
<meta name="description" content="Consulta el recibo de compra de boletos en Lagema. Obtén detalles sobre tu compra y los boletos adquiridos fácilmente.">
<meta name="keywords" content="recibo, boletos, compra, juego, Lagema, pago, recibo boleto">
<meta name="author" content="Lagema">
<meta property="og:title" content="Recibo de Compra - Lagema">
<meta property="og:description" content="Consulta los detalles de tu recibo y los boletos comprados en Lagema. Recibe tus boletos adquiridos y detalles de compra.">
<meta property="og:image" content="<?php echo HOST;?>assets/images/logo.png">
<meta property="og:url" content="<?php echo HOST;?>recibo">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Recibo de Compra - Lagema">
<meta name="twitter:description" content="Consulta los detalles de tu recibo y los boletos comprados en Lagema. Obtén acceso rápido a la información de tu compra.">
<meta name="twitter:image" content="<?php echo HOST;?>assets/images/logo.png">

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">

  <!-- Recibo Section -->
  <section class="bg-white rounded-lg p-8 mb-8 shadow-2xl">

    <?php if (!$cliente): ?>
      <!-- Mostrar mensaje de error si el cliente no es válido -->
      <div class='bg-red-500 text-white p-6 rounded-lg shadow-xl mb-8 flex items-center gap-4'>
          <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01" />
          </svg>
          <p class='text-center font-medium text-xl'>
            El código de recibo es inválido. <br><br> Por favor, si el código es correcto, <br><br> escríbanos al WhatsApp.
          </p>
      </div>
    <?php else: ?>
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-4">Detalles del Recibo</h1>
        <!-- Información del Cliente -->
        <div class="bg-primary p-6 rounded-lg text-white mb-8">
          <div class="flex items-center gap-6">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M19 4H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM16 2v4M8 2v4M3 10h18" />
            </svg>
            <h2 class="font-medium text-xl">Cliente: <strong><?= htmlspecialchars($cliente['nombre']) ?></strong></h2>
          </div>
          <div class="flex items-center gap-6 mt-6">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M5 3h14c1.1 0 1.99.9 1.99 2L21 19c0 1.1-.9 2-1.99 2H5c-1.1 0-1.99-.9-1.99-2L3 5c0-1.1.9-2 1.99-2zM12 14l4-4-4-4v3H8v2h4v3z" />
            </svg>
            <h2 class="font-medium text-xl">Cédula: <strong><?= htmlspecialchars($cliente['cedula']) ?></strong></h2>
          </div>
          <div class="flex items-center gap-6 mt-6">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M5 3h14c1.1 0 1.99.9 1.99 2L21 19c0 1.1-.9 2-1.99 2H5c-1.1 0-1.99-.9-1.99-2L3 5c0-1.1.9-2 1.99-2zM12 14l4-4-4-4v3H8v2h4v3z" />
            </svg>
            <h2 class="font-medium text-xl">Número de Recibo: <strong><?= htmlspecialchars($cliente['numero_recibo']) ?></strong></h2>
          </div>
        </div>

        <!-- Boleto Section -->
        <h3 class="text-2xl font-semibold text-center text-gray-900 mb-6">Boletos Comprados</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
          <?php foreach ($cliente['boletos'] as $boleto): ?>
            <div class="text-white text-center p-8 rounded-lg shadow-xl transition-transform transform hover:scale-110 bg-secundary">
              <p class="text-xl font-semibold">Boleto</p>
              <p class="text-4xl font-bold"><?= htmlspecialchars(str_pad($boleto, 4, '0', STR_PAD_LEFT)) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
  </section>
</main>

<?php include_once DIRPAGE.'components/footer.php'; ?>
