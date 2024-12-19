<?php
    session_start();
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/GanadoresRepository.php';

$ganadorRepo = new GanadoresRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['usuario'])) {
            throw new Exception("No autorizado.", 401);
        }

        // Verificar si es una edición (ID presente en la solicitud)
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception("No se proporcionó el ID de la rifa a editar.");
        }

        $id = (int)$_POST['id'];

        // Verificar si la rifa existe
        $ganadorExistente = $ganadorRepo->findGanadorById($id);
        if (!$ganadorExistente) {
            throw new Exception("El ganador con ID {$id} no existe.");
        }

        if (isset($_FILES['imagen_ganador']) && $_FILES['imagen_ganador']['error'] === UPLOAD_ERR_OK) {
            // Validar foto
            $fotoTmpName = $_FILES['imagen_ganador']['tmp_name'];
            $fotoNameOriginal = basename($_FILES['imagen_ganador']['name']);
            $fotoSize = $_FILES['imagen_ganador']['size'];
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
            $fotoName = "images/ganadores/" . uniqid('ganador') . '.' . $fotoExtension;

            // Subir la foto
            $fotoPath = __DIR__ . "/../assets/" . $fotoName;
            if (!move_uploaded_file($fotoTmpName, $fotoPath)) {
                throw new Exception("No se pudo guardar la foto.");
            }
        } else {
            // Si no se sube una nueva imagen, mantener la imagen existente
            $fotoName = $rifaExistente['imagen_ganador'];
        }

        if($fotoName == "") {
            throw new Exception("No hay foto que subir");
        }

        $resultado = $ganadorRepo->updateImageGanador($id, $fotoName);

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
