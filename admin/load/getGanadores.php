<?php
session_start();
if (!isset($_SESSION['usuario'])) throw new Exception("No tiene permiso", 401);
require_once __DIR__ . '../../components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/GanadoresRepository.php';

$ganadorRepo = new GanadoresRepository();

// Definir cuántos ganadores por página
$ganadorPorPagina = 10;

// Obtener el número de la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $ganadorPorPagina;

// Obtener todos los ganadores con JOIN y paginación
$todosLosGanadores = $ganadorRepo->getGanadoresConPaginacion($ganadorPorPagina, $offset);

// Obtener el total de ganadores para la paginación
$totalGanadores = $ganadorRepo->contarTotalGanador();
$totalPaginas = ceil($totalGanadores / $ganadorPorPagina);
?>

<?php if (empty($todosLosGanadores)): ?>
    <div class="alert alert-warning bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
        No hay registros disponibles
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($todosLosGanadores as $ganador): ?>
            <?php $rowClass = $ganador['id'] % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100'; ?>
            <div class="card rounded-lg shadow-md <?php echo $rowClass; ?> transition transform hover:scale-105 overflow-hidden">

                <?php if (!empty($ganador['imagen_ganador'])): ?>
                    <div class="relative w-full h-48">
                        <img class="w-full h-full object-cover" src="<?php echo HOST_ADMIN; ?>assets/<?php echo $ganador['imagen_ganador']; ?>" alt="Imagen del ganador">
                    </div>
                <?php endif; ?>

                <div class="p-6">
                    <ul class="text-sm text-gray-600 space-y-2 mt-3">
                        <li class="flex items-center">
                            <i class="ri-file-text-line text-lg text-primary me-2"></i> 
                            <span><?php echo $ganador['premio']; ?> </span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-user-line text-lg text-primary me-2"></i>
                            <span><?php echo $ganador['cedula']; ?> - <?php echo $ganador['correo']; ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-trophy-line text-lg text-primary me-2"></i>
                            <span><?php echo $ganador['titulo']; ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-ticket-line text-lg text-primary me-2"></i>
                            <span><?php echo str_pad($ganador['numero_boleto'], 4, '0', STR_PAD_LEFT); ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-phone-line text-lg text-primary me-2"></i>
                            <span><?php echo htmlspecialchars($ganador['telefono']); ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-map-pin-line text-lg text-primary me-2"></i>
                            <span><?php echo htmlspecialchars($ganador['direccion']); ?></span>
                        </li>
                    </ul>
                </div>

                <div class="flex justify-between p-4 bg-gray-100">
                    <button onclick="editarGanador(<?php echo htmlspecialchars(json_encode($ganador)); ?>)" class="text-blue-500 hover:text-blue-700 focus:outline-none text-sm">
                        <i class="ri-edit-line me-2"></i> Editar
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Pagination" class="mt-8 flex justify-center mb-8">
        <ul class="inline-flex items-center -space-x-px">
            <!-- Botón de página anterior -->
            <?php if ($paginaActual > 1): ?>
                <li>
                    <a href="?pagina=<?php echo $paginaActual - 1; ?>" 
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                        Anterior
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <span class="px-3 py-2 leading-tight text-gray-300 bg-gray-100 border border-gray-300 rounded-l-lg cursor-not-allowed">
                        Anterior
                    </span>
                </li>
            <?php endif; ?>

            <!-- Números de página -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li>
                    <a href="?pagina=<?php echo $i; ?>"
                    class="px-3 py-2 leading-tight border <?php echo ($i == $paginaActual) 
                    ? 'bg-blue-50 text-blue-600 border-blue-300' 
                    : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700'; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Botón de página siguiente -->
            <?php if ($paginaActual < $totalPaginas): ?>
                <li>
                    <a href="?pagina=<?php echo $paginaActual + 1; ?>" 
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                        Siguiente
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <span class="px-3 py-2 leading-tight text-gray-300 bg-gray-100 border border-gray-300 rounded-r-lg cursor-not-allowed">
                        Siguiente
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
