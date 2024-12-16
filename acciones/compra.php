<?php
ob_start();
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../admin/components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
    require_once DIRPAGE_ADMIN.'util/Mail.php';
    require_once DIRPAGE_ADMIN.'util/CorreoHelper.php';

    // Validar campos obligatorios
    $requiredFields = ['tiques', 'monto', 'email', 'first-name', 'last-name', 'cedula', 'phone', 'address'];
    foreach ($requiredFields as $field) {
        if ((!isset($_FILES['photo']) && $field === 'photo') || !isset($_POST[$field])) {
            throw new Exception("El campo '$field' es obligatorio", 400);
        }
    }

    // Validar email
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception("El correo electrónico es inválido", 400);
    }

    // Procesar datos
    $photo = $_FILES['photo'];
    $firstName = htmlspecialchars($_POST['first-name']);
    $lastName = htmlspecialchars($_POST['last-name']);
    $cedula = htmlspecialchars($_POST['cedula']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $monto = htmlspecialchars($_POST['monto']);
    $tiques = htmlspecialchars($_POST['tiques']);

    // Crear instancias de repositorios
    $clientesRepo = new ClientesRepository();
    $pagosRepo = new PagosRepository();
    $rifaRepo = new RifaRepository();
    $rifaActiva = $rifaRepo->findActiveRifa();
    if (!$rifaActiva) {
        throw new Exception("No hay una rifa activa disponible.", 404);
    }

    // Obtener el total de boletos disponibles y el total de boletos comprados
    $totalBoletos = (int)$rifaActiva['total_boletos']; // Aseguramos que sea un entero
    $totalComprados = (int)$pagosRepo->getTotalBoletosByRifaId($rifaActiva['id']); // Aseguramos que sea un entero
    
    // Calcular boletos restantes, asegurándonos de que sea un número entero
    $boletosRestantes = $totalBoletos - $totalComprados;
    
    $tiques = (int)$tiques; // Aseguramos que la cantidad de boletos que se quiere comprar también sea un entero
    
    // Validar que el total de boletos a comprar no supere el total disponible
    if ($tiques > $boletosRestantes) {
        throw new Exception("No hay suficientes boletos disponibles. Solo quedan " . $boletosRestantes . " boletos.", 400);
    }

    // Subir archivo de imagen
    $uploadDir = DIRPAGE_ADMIN . 'assets/images/payments/';
    $uploadedFilePath = subirArchivo($photo, $uploadDir);
    if (!$uploadedFilePath) {
        throw new Exception("Hubo un error al subir la imagen.", 500);
    }

    // Buscar o insertar cliente
    $cliente = $clientesRepo->findByEmail($email);
    if (!$cliente) {
        $clienteData = [
            'nombre' => $firstName,
            'apellido' => $lastName,
            'telefono' => $phone,
            'correo' => $email,
            'direccion' => $address,
            'cedula' => $cedula,
        ];
        $clienteId = $clientesRepo->insert($clienteData);
    } else {
        $clienteId = $cliente['id'];
    }

    // Registrar el pago
    $pagoData = [
        'cliente_id' => $clienteId,
        'rifa_id' => $rifaActiva['id'],
        'metodo_pago' => 'pago_movil',
        'tiques' => $tiques,
        'monto' => $monto,
        'imagen_pago' => "images/payments/".basename($uploadedFilePath)
    ];
    $imagen_pago = HOST_ADMIN."assets/images/payments/".basename($uploadedFilePath);
    $pagoId = $pagosRepo->insert($pagoData);

    // Llamada a la clase estática para generar el correo
    $correoHTML = CorreoHelper::generarCorreo($firstName, $lastName, $email, $monto, $tiques, $address, $phone, $imagen_pago);

    // Asunto del correo
    $asunto = 'Nuevo pago recibido';

    // Llamada a la función para enviar el correo
    $result = Mailer::send(
        MAIL_SUPPORT,
        $asunto,
        $correoHTML
    );

    // Verifica si el correo fue enviado correctamente o si hubo un error
    if ($result !== true) {
        throw new Exception("Hubo un error al enviar el email.", 500);
    }

    // Llamada a la clase estática para generar el correo
    $correoHTML = CorreoHelper::generarCorreoCompraPendiente($firstName. " ".$lastName, MAIL_SUPPORT);

    // Asunto del correo
    $asunto = 'Compra recibida: Estamos confirmando tu pago';

    // Llamada a la función para enviar el correo
    $result = Mailer::send(
        $email,
        $asunto,
        $correoHTM
    );

    // Verifica si el correo fue enviado correctamente o si hubo un error
    if ($result !== true) {
        throw new Exception("Hubo un error al enviar el email.", 500);
    }

    echo json_encode(["success" => true, "message" => "Compra realizada con éxito.", "pago_id" => $pagoId]);
} catch (Exception $e) {
    // Manejo de excepciones y errores
    $statusCode = $e->getCode() == 200 ? 500 : $e->getCode(); // Por defecto, error 500
    http_response_code($statusCode);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    error_log("Error en la compra: " . $e->getMessage());
    exit;
}
?>
