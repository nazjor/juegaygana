<?php
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';

$pagoRepo = new PagosRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar si es una edición (ID presente en la solicitud)
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception("No se proporcionó el ID de la rifa a editar.");
        }

        $id = (int)$_POST['id'];

        // Verificar si el pago existe
        $pagoExistente = $pagoRepo->findPagoById($id);
        if (!$pagoExistente) {
            throw new Exception("El pago con ID {$id} no existe.");
        }

        if($pagoExistente['estado'] != "creado") {
            throw new Exception("El estado pago solo se puede cambiar si es creado.");
        }

        // Verificar y procesar la fecha de inicio
        if (!isset($_POST['estado_pago']) || empty($_POST['estado_pago'])) {
            throw new Exception("El estado pago es requerida.");
        }

        // Usar el método del repositorio para actualizar la rifa
        $resultado = $pagoRepo->updatePagoState($id, $_POST['estado_pago']);

        if ($resultado) {
            echo json_encode(["success" => true, "message" => "Rifa actualizada correctamente."]);
        } else {
            throw new Exception("Error al actualizar el pago.");
        }

    } catch (Exception $e) {
        // Manejo de excepciones
        http_response_code(400); // Devolver código de estado HTTP 400
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
