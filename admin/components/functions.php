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
