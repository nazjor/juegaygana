<?php
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

function enviarCorreo($to, $subject, $message) {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: ' . MAIL_FROM . "\r\n";
    $headers .= 'Reply-To: ' . MAIL_FROM . "\r\n";
    
    // Configuración del correo SMTP para Hostinger
    $smtp_server = 'smtp.hostinger.com';
    $smtp_port = 465; // Puerto SSL
    $username = MAIL_FROM; // El correo desde el que envías
    $password = MAIL_PASSWORD; // La contraseña de ese correo

    // Establecer la conexión con el servidor SMTP
    $smtp_conn = fsockopen($smtp_server, $smtp_port, $errno, $errstr, 30);
    if (!$smtp_conn) {
        throw new Exception("No se pudo conectar al servidor SMTP: $errstr ($errno)", 500);
    }

    // Respuesta del servidor después de la conexión
    $response = fgets($smtp_conn, 1024);
    if (substr($response, 0, 3) != '220') {
        throw new Exception("Error de conexión: $response");
    }

    // Enviar el comando EHLO
    fputs($smtp_conn, "EHLO $smtp_server\r\n");
    $response = fgets($smtp_conn, 1024);
    if (substr($response, 0, 3) != '250') {
        throw new Exception("Error en EHLO: $response");
    }

    // Autenticación con AUTH LOGIN
    fputs($smtp_conn, "AUTH LOGIN\r\n");
    $response = fgets($smtp_conn, 1024);
    if (substr($response, 0, 3) != '334') {
        throw new Exception("Error en AUTH LOGIN: $response");
    }

    // Enviar el usuario y la contraseña codificados en base64
    fputs($smtp_conn, base64_encode($username) . "\r\n");
    $response = fgets($smtp_conn, 1024);
    fputs($smtp_conn, base64_encode($password) . "\r\n");
    $response = fgets($smtp_conn, 1024);

    // Comando MAIL FROM (remitente)
    fputs($smtp_conn, "MAIL FROM:<$username>\r\n");
    $response = fgets($smtp_conn, 1024);

    // Comando RCPT TO (destinatario)
    fputs($smtp_conn, "RCPT TO:<$to>\r\n");
    $response = fgets($smtp_conn, 1024);

    // Comando DATA (cuerpo del mensaje)
    fputs($smtp_conn, "DATA\r\n");
    $response = fgets($smtp_conn, 1024);

    // Enviar el encabezado del correo
    fputs($smtp_conn, "Subject: $subject\r\n");
    fputs($smtp_conn, $headers . "\r\n");
    fputs($smtp_conn, "\r\n$message\r\n.\r\n");

    // Finalizar la conexión
    $response = fgets($smtp_conn, 1024);
    fputs($smtp_conn, "QUIT\r\n");
    fclose($smtp_conn);

    // Verificar si se recibió una respuesta exitosa
    if (substr($response, 0, 3) != '250') {
        throw new Exception("Error al enviar el correo: $response");
    }

    echo "Correo enviado exitosamente.";
}
