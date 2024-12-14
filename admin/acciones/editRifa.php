<?php
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';

$rifaRepo = new RifaRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar si es una edición (ID presente en la solicitud)
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception("No se proporcionó el ID de la rifa a editar.");
        }

        $id = (int)$_POST['id'];

        // Verificar si la rifa existe
        $rifaExistente = $rifaRepo->findRifaById($id);
        if (!$rifaExistente) {
            throw new Exception("La rifa con ID {$id} no existe.");
        }

        // Verificar y recoger el nombre del formulario
        if (!isset($_POST['titulo']) || empty($_POST['titulo'])) {
            throw new Exception("El título es requerido.");
        }
        $nombre = $_POST['titulo'];

        // Verificar que el número de boletos esté dentro del rango
        if (!isset($_POST['total_boletos']) || empty($_POST['total_boletos'])) {
            throw new Exception("El total de boletos es requerido.");
        }
        $boletosMaximos = (int)$_POST['total_boletos'];
        if ($boletosMaximos < 1000 || $boletosMaximos > 9999) {
            throw new Exception(" número de boletos debe estar entre 1000 y 9999.");
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

        // Manejo de la imagen (opcional)
   
        if (isset($_FILES['imagen_rifa']) && $_FILES['imagen_rifa']['error'] === UPLOAD_ERR_OK) {
            // Validar foto
            $fotoTmpName = $_FILES['imagen_rifa']['tmp_name'];
            $fotoNameOriginal = basename($_FILES['imagen_rifa']['name']);
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
            $fotoExtension = pathinfo($fotoNameOriginal, PATHINFO_EXTENSION);
            $fotoName = "images/products/" . uniqid('rifa_') . '.' . $fotoExtension;

            // Subir la foto
            $fotoPath = __DIR__ . "/../assets/" . $fotoName;
            if (!move_uploaded_file($fotoTmpName, $fotoPath)) {
                throw new Exception("No se pudo guardar la foto.");
            }
        } else {
            // Si no se sube una nueva imagen, mantener la imagen existente
            $fotoName = $rifaExistente['imagen_rifa'];
        }

        // Usar el método del repositorio para actualizar la rifa
        $resultado = $rifaRepo->updateRifa($id, $nombre, $fotoName, $boletosMaximos, $fechaInicioFormatted, $precioBoleto);

        if ($resultado) {
            echo json_encode(["success" => true, "message" => "Rifa actualizada correctamente."]);
        } else {
            throw new Exception("Error al actualizar la rifa.");
        }

    } catch (Exception $e) {
        // Manejo de excepciones
        http_response_code(400); // Devolver código de estado HTTP 400
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
