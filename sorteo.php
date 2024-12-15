<?php
$title = 'Seleccionar Ganador - Juega y Gana';
require_once 'admin/components/init.php';
require_once DIRPAGE.'components/header.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
$rifaRepo = new RifaRepository();
$rifaActiva = $rifaRepo->findActiveRifa();

// Verifica si ya existe un ganador
// $ganador = $rifaRepo->getGanador($rifaActiva['id']); // Suponiendo que este método trae el ganador, si existe.

$ganador = null;

// $ganador = [
//     'nombre' => 'Juan Pérez',
//     'cedula' => 'V-12345678',
//     'boleto' => '#12345',
//     'premio' => 'Un Televisor'
// ];

$existeGanador = $ganador == null ? "¡ Gana un <strong>". ($rifaActiva['titulo'])."<strong> !"  : "Felicidades ".$ganador['nombre'];
?>

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">

<!-- Details Section -->
<section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
    <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900"><?php echo($existeGanador)?></h2>
  </section>

  <!-- New Image Section -->
  <section class="relative rounded-xl overflow-hidden mb-6">
    <img src="<?php echo HOST_ADMIN.'assets/'.$rifaActiva['imagen_rifa']?>" alt="Imagen de promoción" class="w-full h-72 object-cover rounded-lg shadow-lg">
  </section>

  <!-- Seleccionar Ganador Section -->
  <section class="bg-white rounded-lg p-8 shadow-2xl mb-8">

    <?php if ($ganador === null): ?>
      <div class="text-center mb-8">
        <button id="botonSeleccionar" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">
          Sortear
        </button>
      </div>

      <div id="animacion" class="hidden text-center">
        <div class="spinner"></div>
        <p class="text-xl font-semibold">Eligiendo ganador...</p>
      </div>

    <?php else: ?>
      <div id="ganador" class="mt-8 text-center">
        <h3 class="text-2xl font-semibold">¡Nuestro ganador!</h3>
        <p class="text-lg">Ganador: <strong><?php echo $ganador['nombre']; ?></strong></p>
        <p class="text-lg">Cédula: <strong><?php echo $ganador['cedula']; ?></strong></p>
        <p class="text-lg">Boleto: <strong><?php echo $ganador['boleto']; ?></strong></p>
        <p class="text-lg">Premio: <strong><?php echo $ganador['premio']; ?></strong></p>
      </div>
    <?php endif; ?>

  </section>
</main>

<?php include_once DIRPAGE.'components/footer.php'; ?>

<script>
  document.getElementById('botonSeleccionar').addEventListener('click', function() {
    document.getElementById('animacion').classList.remove('hidden');

    // Simular la animación de 5 segundos antes de mostrar al ganador
    setTimeout(function() {
        location.reload();
    }, 5000); // 5 segundos
  });
</script>

<style>
  /* Animación de spinner */
  .spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
    margin: 0 auto;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
