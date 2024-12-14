<?php
ob_start();
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../admin/components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';

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
            'direccion' => $address
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
    $pagoId = $pagosRepo->insert($pagoData);

    // Uso de la función para enviar un correo
    $to = 'jrvazquezantelo@gmail.com'; // Correo del administrador
    $subject = 'Nueva compra realizada';
    $message = '<h1>¡Nueva compra realizada!</h1><p>Un cliente ha realizado una compra. Por favor, confirme el pago en el siguiente enlace: <a href="http://tusitio.com/pago.php?id=123">Confirmar pago</a></p>';

    enviarCorreo($to, $subject, $message);

    // Respuesta de éxito
    echo json_encode(["success" => true, "message" => "Compra realizada con éxito.", "pago_id" => $pagoId]);

} catch (Exception $e) {
    // Manejo de excepciones y errores
    $statusCode = $e->getCode() == 200 ? 500 : $e->getCode(); // Por defecto, error 500
    http_response_code($statusCode);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    error_log("Error en la compra: " . $e->getMessage());
    exit;
}
