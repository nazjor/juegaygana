<?php
session_start();
require_once __DIR__ . '../../components/init.php';

// Repositorios y utilidades
$requiredFiles = [
    'repositories/RifaRepository.php',
    'repositories/BoletosRepository.php',
    'repositories/ClientesRepository.php',
    'repositories/GanadoresRepository.php',
    'util/Mail.php',
    'util/CorreoHelper.php',
    'util/UtilEncriptacion.php'
];
foreach ($requiredFiles as $file) {
    require_once DIRPAGE_ADMIN . $file;
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    // Validaciones iniciales
    if (!isset($_SESSION['usuario'])) {
        throw new Exception("No autorizado.", 401);
    }

    if (!isset($data['numerosGanadores']) || !is_array($data['numerosGanadores'])) {
        throw new Exception("No se proporcionaron los números ganadores.", 400);
    }

    // Extraer premios
    $premios = array_map('intval', $data['numerosGanadores']);
    
    if (count($premios) < 3) {
        throw new Exception("Se requieren al menos 3 números ganadores.", 400);
    }

    $premios = array_reverse(array_map('intval', $data['numerosGanadores']));

    // Instanciar repositorios
    $rifaRepo = new RifaRepository();
    $boletoRepo = new BoletosRepository();
    $clienteRepo = new ClientesRepository();
    $ganadorRepo = new GanadoresRepository();

    // Obtener la rifa activa
    $rifaActiva = $rifaRepo->findActiveRifa();

    // Procesar premios
    foreach ($premios as $index => $premio) {
        $boletoGanador = $boletoRepo->findByBoletoAndRifaId($premio, $rifaActiva['id']);
        if (!$boletoGanador) {
            throw new Exception("No se encontró el boleto ganador para el premio " . ($index + 1), 400);
        }

        $cliente = $clienteRepo->findClienteById($boletoGanador['cliente_id']);
        if (!$cliente) {
            throw new Exception("No se encontró el cliente para el boleto ganador.", 400);
        }

        // Preparar y enviar correo
        $asunto = "Felicidades, has ganado en nuestro sorteo";
        $codigoCompra = str_pad($boletoGanador['pago_id'], 8, '0', STR_PAD_LEFT);
        $codigoEncriptado = UtilEncriptacion::encriptar($codigoCompra);
        $enlace = HOST . 'recibo/' . $codigoEncriptado;
        $fullname = $cliente['nombre'] . " " . $cliente['apellido'];
        $correoHTML = CorreoHelper::generarCorreoGanador(
            $fullname, 
            $cliente['telefono'], 
            $rifaActiva['titulo'], 
            $enlace
        );

        // Insertar ganador
        $ganadorRepo->insertarGanador($boletoGanador['id'], "premio" . ($index + 1));

        // Enviar correos
        if (!Mailer::send($cliente['correo'], $asunto, $correoHTML)) {
            throw new Exception("Error al enviar el correo al ganador.", 500);
        }

        if (!Mailer::send(MAIL_SUPPORT, $asunto, $correoHTML)) {
            throw new Exception("Error al enviar el correo al soporte.", 500);
        }
    }

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    $errorCode = $e->getCode() === 500 ? 500 : 400;
    http_response_code($errorCode);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
