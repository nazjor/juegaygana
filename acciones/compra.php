<?php
ob_start();
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../admin/components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';

    // Validar campos obligatorios
    $requiredFields = ['email', 'first-name', 'last-name', 'cedula', 'phone', 'address'];
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

    // Subir archivo de imagen
    $uploadDir = DIRPAGE_ADMIN . 'assets/images/payments/';
    $uploadedFilePath = subirArchivo($photo, $uploadDir);
    if (!$uploadedFilePath) {
        throw new Exception("Hubo un error al subir la imagen.", 500);
    }

    // Crear instancias de repositorios
    $clientesRepo = new ClientesRepository();
    $pagosRepo = new PagosRepository();
    $rifaRepo = new RifaRepository();
    $rifaActiva = $rifaRepo->findActiveRifa();
    if (!$rifaActiva) {
        throw new Exception("No hay una rifa activa disponible.", 404);
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
        'metodo_pago' => 'pago_movil', // Cambiar según sea necesario
        'imagen_pago' => "images/payments/".basename($uploadedFilePath)
    ];
    $pagoId = $pagosRepo->insert($pagoData);

    // Respuesta de éxito
    echo json_encode(["success" => true, "message" => "Compra realizada con éxito.", "pago_id" => $pagoId]);

} catch (Exception $e) {
    // Manejo de excepciones y errores
    $statusCode = $e->getCode() ?: 500; // Por defecto, error 500
    http_response_code($statusCode);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    error_log("Error en la compra: " . $e->getMessage());
}

/**
 * Subir archivo de imagen al servidor
 *
 * @param array $file Archivo subido ($_FILES['photo'])
 * @param string $dir Directorio destino para la subida
 * @return string|false Ruta del archivo subido o false en caso de error
 */
function subirArchivo($file, $dir)
{
    try {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error en la subida del archivo: Código " . $file['error'], 400);
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Formato de archivo no permitido. Solo se aceptan JPG, JPEG y PNG.", 400);
        }

        $uniqueFileName = uniqid('payment_', true) . '.' . $fileExtension;
        $uploadFile = $dir . $uniqueFileName;

        if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
            throw new Exception("No se pudo crear el directorio de subida.", 500);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
            throw new Exception("No se pudo mover el archivo subido al directorio destino.", 500);
        }

        return $uploadFile;
    } catch (Exception $e) {
        error_log("Error en la función subirArchivo: " . $e->getMessage());
        throw $e;
    }
}
