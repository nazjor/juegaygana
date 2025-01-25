<?php
session_start();
if (!isset($_SESSION['usuario'])) throw new Exception("No tiene permiso", 401);
require_once __DIR__ . '../../components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
require_once DIRPAGE_ADMIN . 'util/UtilFecha.php';
require_once DIRPAGE_ADMIN . 'util/UtilEncriptacion.php';

$pagoRepo = new PagosRepository();

// Definir cuántos pagos por página
$pagosPorPagina = 10;

// Obtener el número de la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $pagosPorPagina;

// Recibir los filtros desde los parámetros GET
$filtros = [
    'estado' => isset($_GET['estado']) ? $_GET['estado'] : '',
    'correo' => isset($_GET['email']) ? $_GET['email'] : '',
    'fechaInicio' => isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '',
    'fechaFin' => isset($_GET['fechaFin']) ? $_GET['fechaFin'] : ''
];

// Si hay fechas en los filtros
if (!empty($filtros['fechaInicio']) || !empty($filtros['fechaFin'])) {
    // Si solo está definida fechaFin
    if (!empty($filtros['fechaFin']) && empty($filtros['fechaInicio'])) {
        $filtros['fechaInicio'] = $filtros['fechaFin']; // Usar fechaFin como fechaInicio
    }
    // Si solo está definida fechaInicio
    if (!empty($filtros['fechaInicio']) && empty($filtros['fechaFin'])) {
        $filtros['fechaFin'] = date('Y-m-d'); // Usar el día actual como fechaFin
    }

    // Convertir las fechas a formato DateTime
    $fechaInicio = new DateTime($filtros['fechaInicio']);
    $fechaFin = new DateTime($filtros['fechaFin']);

    // Validar que fechaInicio sea menor que fechaFin
    if ($fechaInicio > $fechaFin) {
        echo '<div class="alert alert-warning bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">La fecha de inicio no puede ser posterior a la fecha de fin. Si no se especifica una fecha de fin, se tomará el día de hoy por defecto.</div>';
        return;
    }

    // Ajustar las fechas al inicio y fin del día
    $filtros['fechaInicio'] = $fechaInicio->format('Y-m-d 00:00:00');
    $filtros['fechaFin'] = $fechaFin->format('Y-m-d 23:59:59');
} else {
    // Si no se proporcionan fechas, no aplicar filtros
    unset($filtros['fechaInicio'], $filtros['fechaFin']);
}

// Obtener todos los pagos con paginación y filtros
$todosLosPagos = $pagoRepo->findPagosConPaginacion($pagosPorPagina, $offset, $filtros);
$totalPagos = $pagoRepo->contarTotalPagos();
$totalPaginas = ceil($totalPagos / $pagosPorPagina);
?>

<?php if (empty($todosLosPagos)): ?>
        <!-- Mostrar filtros y sus valores -->
    <div class="alert alert-warning bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
        <?php if ($filtros['estado']) echo '<p><strong>Criterios de búsqueda:</strong></p> '; ?>
        <ul>
            <?php if ($filtros['estado']) echo '<li><strong>Estado:</strong> ' . htmlspecialchars($filtros['estado']) . '</li>'; ?>
            <?php if ($filtros['correo']) echo '<li><strong>Correo:</strong> ' . htmlspecialchars($filtros['correo']) . '</li>'; ?>
            <?php if ($filtros['fechaInicio']) echo '<li><strong>Fecha inicio:</strong> ' . htmlspecialchars($filtros['fechaInicio']) . '</li>'; ?>
            <?php if ($filtros['fechaFin']) echo '<li><strong>Fecha fin:</strong> ' . htmlspecialchars($filtros['fechaFin']) . '</li>'; ?>
        </ul>
    </div>

    <div class="alert alert-warning bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
        No hay registros disponibles con los criterios de búsqueda seleccionados.
    </div>
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
                        <span><?php echo  UtilFecha::formatearFecha($pago['fecha_pago']); ?></span>
                    </li>
                    <li class="flex items-center">
                        <i class="ri-price-tag-3-line text-lg text-primary me-2"></i>
                        <span><?php echo $pago['monto']; ?> Bs </span>
                    </li>
                    <li class="flex items-center">
                        <i class="ri-price-tag-2-line text-lg text-primary me-2"></i>
                        <span><?php echo $pago['tiques']; ?> </span>
                    </li>
                    <li class="flex items-center">
                        <i class="ri-phone-line text-lg text-primary me-2"></i>
                        <span><?php echo htmlspecialchars($pago['telefono']); ?></span>
                    </li>
                    <li class="flex items-center">
                        <i class="ri-map-pin-line text-lg text-primary me-2"></i>
                        <span><?php echo htmlspecialchars($pago['direccion']); ?></span>
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
                <button onclick="reenviarBoleto(<?php echo htmlspecialchars(json_encode($pago)); ?>)" class="text-yellow-500 hover:text-blue-700 focus:outline-none text-sm">
                    <i class="ri-mail-line me-2"></i> Reenviar
                </button>
                <?php 
                    $codigoCompra = str_pad($pago['id'], 8, '0', STR_PAD_LEFT);
                    $codigoEncriptado = UtilEncriptacion::encriptar($codigoCompra);
                ?>
                <a href="<?php echo HOST."/recibo/".$codigoEncriptado; ?>" class="text-green-500 hover:text-green-700 focus:outline-none text-sm">
                    <i class="ri-eye-line me-2"></i> Recibo
                </a>
               

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
