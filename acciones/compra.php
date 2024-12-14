<?php
ob_start();
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../admin/components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
    require_once DIRPAGE.'util/Mail.php';

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
    $imagen_pago = HOST_ADMIN."assets/images/payments/".basename($uploadedFilePath);
    $pagoId = $pagosRepo->insert($pagoData);

    // Logo y cuerpo del correo en formato moderno
    $logoUrl = HOST.'assets/images/logo.png';
    $correoHTML = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f9;
                    color: #333;
                }
                .email-container {
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .email-header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .email-header img {
                    width: 150px;
                    height: auto;
                }
                .email-body {
                    font-size: 16px;
                    line-height: 1.6;
                }
                .email-body h2 {
                    color: #333;
                    font-size: 22px;
                    margin-bottom: 10px;
                }
                .email-body ul {
                    list-style-type: none;
                    padding: 0;
                }
                .email-body ul li {
                    padding: 5px 0;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 12px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <img src='$logoUrl' alt='Logo del Sistema' />
                </div>
                <div class='email-body'>
                    <h2>Nuevo pago recibido</h2>
                    <p>Se ha realizado una nueva compra. Aquí están los detalles:</p>
                    <ul>
                        <li><strong>Nombre:</strong> $firstName $lastName</li>
                        <li><strong>Email:</strong> $email</li>
                        <li><strong>Monto:</strong> $$monto</li>
                        <li><strong>Cantidad de boletos:</strong> $tiques</li>
                        <li><strong>Dirección:</strong> $address</li>
                        <li><strong>Teléfono:</strong> $phone</li>
                    </ul>
                    <p><strong>Imagen del pago:</strong></p>
                    <img src='$imagen_pago' alt='Imagen de pago' style='width: 300px; height: auto;' />
                </div>
                <div class='footer'>
                    <p>Gracias por usar nuestro sistema. ¡Buena suerte en la rifa!</p>
                </div>
            </div>
        </body>
        </html>
    ";

    // Asunto del correo
    $asunto = 'Nuevo pago recibido - ' . $firstName . ' ' . $lastName;

    // Llamada a la función para enviar el correo
    $result = Mailer::send(
        'jrvazquezantelo@gmail.com', // Dirección del destinatario
        $asunto,                     // Asunto
        $correoHTML                  // Cuerpo del correo en HTML
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
