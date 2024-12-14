<?php

header('Content-Type: application/json'); // Aseguramos que la respuesta sea JSON

try {
    require_once __DIR__ . '/../admin/components/init.php';

    // Verificamos si se recibieron los datos del formulario
    if (!isset($_FILES['photo']) || !isset($_POST['email']) || !isset($_POST['first-name']) || 
        !isset($_POST['last-name']) || !isset($_POST['cedula']) || !isset($_POST['phone']) || 
        !isset($_POST['address'])) {
        // Si falta algún dato, respondemos con error
        http_response_code(400); // Código HTTP de solicitud incorrecta
        echo json_encode(["message" => "Faltan datos requeridos"]);
        exit;
    }

    // Procesar los datos del formulario
    $photo = $_FILES['photo'];  // El archivo de foto
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $cedula = $_POST['cedula'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Aquí puedes agregar la lógica para guardar la información, como almacenar la foto y los datos del usuario.
    // Por ejemplo, si la foto se sube correctamente:
    $uploadDir = DIRPAGE_ADMIN . 'assets/images/payments/';
    $uploadFile = $uploadDir . basename($photo['name']);
    
    if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
        // Aquí podrías guardar los otros datos en una base de datos, si es necesario
        // Ejemplo: insertar los datos en la base de datos

        // Si todo está bien, respondemos con un mensaje de éxito
        echo json_encode(["success" => true, "message" => "Compra realizada con éxito."]);
        exit;
    } else {
        // Si hubo un error con la subida de la foto
        http_response_code(500); // Código HTTP de error interno del servidor
        echo json_encode(["success" => false, "message" => "Hubo un error al procesar la foto."]);
        exit;
    }
} catch (Exception $e) {
    // Manejo de errores o excepciones
    error_log('Error en la compra: ' . $e->getMessage());
    http_response_code(500); // Código HTTP de error interno del servidor
    echo json_encode(["success" => false, "message" => "Error interno del servidor"]);
    exit;
}
