<?php
    session_start();
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/GanadoresRepository.php';

    $rifaRepo = new RifaRepository();
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
            $rifaExistente = $rifaRepo->findRifaById($id);
            if (!$rifaExistente) {
                throw new Exception("La rifa con ID {$id} no existe.");
            }

            $rifaActiva = $rifaRepo->findActiveRifa();

            if (!$rifaActiva) {
                throw new Exception("No hay rifas activas en este momento");
            }

            $ganadores = $ganadorRepo->countGanadoresByRifaId($rifaActiva['id']); 

            if ($ganadores == 0) {
                throw new Exception("No puedes finalizar una rifa sin haber seleccionado un ganador.");
            }            

            // Usar el método del repositorio para actualizar la rifa
            $resultado = $rifaRepo->updateRifaState($id, "finalizada");

            if ($resultado) {
                echo json_encode(["success" => true, "message" => "Rifa terminada correctamente."]);
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
