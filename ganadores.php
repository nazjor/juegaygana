<?php
$title = 'Ganadores - Juega y Gana';
require_once 'admin/components/init.php';
require_once DIRPAGE.'components/header.php';
require_once DIRPAGE_ADMIN . 'repositories/GanadoresRepository.php';

// Obtener los ganadores desde el repositorio
$ganadoresRepo = new GanadoresRepository();
$ganadores = $ganadoresRepo->ob();
?>

<!-- Main -->
<main class="flex-1 bg-gray-100">

  <!-- Ganadores Section -->
  <section class="bg-white rounded-lg p-8 shadow-2xl">

    <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Ganadores Recientes</h2>

    <?php if (empty($ganadores)): ?>
      <div class="bg-red-500 p-6 rounded-lg shadow-xl mb-8 flex items-center gap-4">
          <i class="ri-error-warning-line text-lg text-white me-2"></i>
          <p class="text-center font-medium text-xl text-white">
            No hay ganadores disponibles en este momento.
          </p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        <?php foreach ($ganadores as $ganador): ?>
          <div class="bg-white rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition duration-500 border-4 border-blue-500">
            <img src="<?= htmlspecialchars($ganador['foto']) ?>" alt="Foto de <?= htmlspecialchars($ganador['nombre']) ?>" class="w-full h-48 object-cover rounded-t-lg">

            <div class="p-6 text-gray-900 rounded-b-lg">
              <h3 class="text-2xl font-semibold"><?= htmlspecialchars($ganador['nombre']) ?></h3>
              <div class="mt-4 space-y-2">
                <div class="flex items-center">
                  <i class="ri-user-line text-lg text-blue-500 me-2"></i>
                  <p class="ml-2 text-lg"><?= htmlspecialchars($ganador['cedula']) ?></p>
                </div>
                <div class="flex items-center">
                  <i class="ri-ticket-2-line text-lg text-blue-500 me-2"></i>
                  <p class="ml-2 text-lg"><?= htmlspecialchars($ganador['boleto']) ?></p>
                </div>
                <div class="flex items-center">
                  <i class="ri-trophy-line text-lg text-yellow-500 me-2"></i>
                  <p class="ml-2 text-lg"><?= htmlspecialchars($ganador['premio']) ?></p>
                </div>
                <div class="flex items-center">
                  <i class="ri-calendar-check-line text-lg text-green-500 me-2"></i>
                  <p class="ml-2 text-lg"><?= htmlspecialchars($ganador['fecha']) ?></p>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    
  </section>
</main>

<?php include_once DIRPAGE.'components/footer.php'; ?>
