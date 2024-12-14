<?php
require_once __DIR__ . '../../components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';

$rifaRepo = new RifaRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar si se envió la foto y el campo de boletos
        if (isset($_FILES['imagen_rifa']) && $_FILES['imagen_rifa']['error'] === UPLOAD_ERR_OK) {
            // Validar foto
            $fotoTmpName = $_FILES['imagen_rifa']['tmp_name'];
            $fotoName = basename($_FILES['imagen_rifa']['name']);
            $fotoSize = $_FILES['imagen_rifa']['size'];
            $fotoType = mime_content_type($fotoTmpName);

            // Validar que el tipo de archivo sea una imagen (JPEG, PNG, GIF)
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fotoType, $validMimeTypes)) {
                throw new Exception("La foto debe ser una imagen JPG, PNG o GIF.");
            }

            // Validar el tamaño de la imagen (máximo 5MB)
            if ($fotoSize > 5 * 1024 * 1024) {
                throw new Exception("La foto no debe superar los 5MB.");
            }

            // Generar un nombre único para la foto
            $fotoExtension = pathinfo($fotoName, PATHINFO_EXTENSION);
            $fotoName = uniqid('rifa_') . '.' . $fotoExtension;

            // Subir la foto
            $fotoPath = __DIR__ . "/../assets/images/products/" . $fotoName;
            if (!move_uploaded_file($fotoTmpName, $fotoPath)) {
                throw new Exception("No se pudo guardar la foto.");
            }
        } else {
            throw new Exception("No se envió ninguna foto.");
        }

        // Verificar que el número de boletos esté dentro del rango
        $boletosMaximos = (int)$_POST['total_boletos'];
        if ($boletosMaximos < 1000 || $boletosMaximos > 9999) {
            throw new Exception("El número de boletos debe estar entre 1000 y 9999.");
        }

        // Verificar y procesar la fecha de inicio
        if (!isset($_POST['fecha_inicio']) || empty($_POST['fecha_inicio'])) {
            throw new Exception("La fecha de inicio es requerida.");
        }
        $fechaInicio = $_POST['fecha_inicio'];
        $fechaInicioFormatted = date('Y-m-d', strtotime($fechaInicio));
        if ($fechaInicioFormatted === false) {
            throw new Exception("La fecha de inicio no tiene un formato válido.");
        }

        // Verificar y procesar el precio del boleto
        if (!isset($_POST['precio_boleto']) || empty($_POST['precio_boleto']) || !is_numeric($_POST['precio_boleto'])) {
            throw new Exception("El precio del boleto es requerido y debe ser un valor numérico.");
        }
        $precioBoleto = (float)$_POST['precio_boleto'];

        // Recoger el nombre del formulario
        $nombre = $_POST['titulo'];

        // Guardar el nombre de la imagen
        $fotoName = "images/products/" . $fotoName;

        // Usar el método del repositorio para guardar la rifa
        $resultado = $rifaRepo->insertRifa($nombre, $fotoName, $boletosMaximos, $fechaInicioFormatted, $precioBoleto);

        if ($resultado) {
            echo "Rifa guardada correctamente.";
        } else {
            throw new Exception("Error al guardar la rifa.");
        }

    } catch (Exception $e) {
        // Manejo de excepciones
        http_response_code(400); // Devolver código de estado HTTP 400
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
