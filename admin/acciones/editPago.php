<?php
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN.'util/Mail.php';
    require_once DIRPAGE_ADMIN.'util/CorreoHelper.php';
    require_once DIRPAGE_ADMIN.'util/UtilEncriptacion.php';

$pagoRepo = new PagosRepository();
$clienteRepo = new ClientesRepository();

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
            if ($_POST['estado_pago'] == "aprobado") {

                $cliente = $clienteRepo->findClienteById($pagoExistente['cliente_id']);

                if (!$cliente) {
                    throw new Exception("El cliente con ID {$id} no existe.");
                }

                $fullname = $cliente['nombre']. " ". $cliente['apellido']; 
                // Asunto del correo
                $asunto = "¡Tu compra $fullname ha sido aprobada! 🎉";

                $codigoCompra = str_pad($pagoExistente['id'], 8, '0', STR_PAD_LEFT);

                // Llamada a la clase estática para generar el correo
                $codigoEncriptado = UtilEncriptacion::encriptar($codigoCompra);
                $enlace = HOST.'recibo/'.$codigoEncriptado;
                $correoHTML = CorreoHelper::generarCorreoCompraAprobada($fullname, $codigoCompra, $enlace);

                // Llamada a la función para enviar el correo
                $result = Mailer::send(
                    $cliente['correo'],
                    $asunto,
                    $correoHTML
                );

                // Verifica si el correo fue enviado correctamente o si hubo un error
                if ($result !== true) {
                    throw new Exception("Hubo un error al enviar el email.", 500);
                }
            }
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
