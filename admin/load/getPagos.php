<?php
session_start();
if (!isset($_SESSION['usuario'])) throw new Exception("No tiene permiso", 401);
require_once __DIR__ . '../../components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';

$pagoRepo = new PagosRepository();

// Definir cuántos pagos por página
$pagosPorPagina = 10;

// Obtener el número de la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

$offset = ($paginaActual - 1) * $pagosPorPagina;

// Obtener todos los pagos con paginación
$todosLosPagos = $pagoRepo->findPagosConPaginacion($pagosPorPagina, $offset);
$totalPagos = $pagoRepo->contarTotalPagos();
$totalPaginas = ceil($totalPagos / $pagosPorPagina);
?>

<?php if (empty($todosLosPagos)): ?>
    <tr>
        <td colspan="4" class="text-center text-gray-500">No hay pagos disponibles</td>
    </tr>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($todosLosPagos as $pago): ?>
            <?php $rowClass = $pago['id'] % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100'; ?>
            <div class="card rounded-lg shadow-md <?php echo $rowClass; ?> transition transform hover:scale-105 overflow-hidden">
                <div class="relative w-full h-48">
                    <img class="w-full h-full object-cover" src="<?php echo HOST_ADMIN; ?>assets/<?php echo $pago['imagen_pago']; ?>" alt="Imagen del pago">
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700"><?php echo htmlspecialchars($pago['correo']); ?></h3>
                    <ul class="text-sm text-gray-600 space-y-2 mt-3">
                        <li class="flex items-center">
                            <i class="ri-file-text-line text-lg text-primary me-2"></i> 
                            <span><?php echo $pago['titulo']; ?> </span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-calendar-check-line text-lg text-primary me-2"></i> 
                            <span><?php echo date('l, j F Y', strtotime($pago['fecha_pago'])); ?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-price-tag-3-line text-lg text-primary me-2"></i>
                            <span><?php echo $pago['monto']; ?> Bs </span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-price-tag-2-line text-lg text-primary me-2"></i>
                            <span><?php echo $pago['tiques']; ?> Bs </span>
                        </li>
                        <li class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-<?php echo ($pago['estado'] == 'aprobado') ? 'green' : ($pago['estado'] == 'anulado' ? 'red' : 'yellow'); ?>-200 text-<?php echo ($pago['estado'] == 'aprobado') ? 'green' : ($pago['estado'] == 'anulado' ? 'red' : 'yellow'); ?>-800"><?php echo ucfirst($pago['estado']); ?></span>
                        </li>
                    </ul>
                </div>

                <div class="flex justify-between p-4 bg-gray-100">
                    <button onclick="editarPago(<?php echo htmlspecialchars(json_encode($pago)); ?>)" class="text-blue-500 hover:text-blue-700 focus:outline-none text-sm">
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
