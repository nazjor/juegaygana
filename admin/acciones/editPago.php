<?php
session_start();

require_once __DIR__ . '../../components/init.php';
require_once DIRPAGE_ADMIN . 'repositories/PagosRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/BoletosRepository.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
require_once DIRPAGE_ADMIN . 'util/Mail.php';
require_once DIRPAGE_ADMIN . 'util/CorreoHelper.php';
require_once DIRPAGE_ADMIN . 'util/UtilEncriptacion.php';

$pagoRepo = new PagosRepository();
$clienteRepo = new ClientesRepository();
$boletosRepo = new BoletosRepository();
$rifaRepo = new RifaRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['usuario'])) {
            throw new Exception("No autorizado.", 401);
        }
        
        // Validar que el ID de la rifa esté presente
        if (empty($_POST['id'])) {
            throw new Exception("No se proporcionó el ID del pago a editar.");
        }

        $pagoId = (int)$_POST['id'];

        // Validar la existencia del pago
        $pagoExistente = $pagoRepo->findPagoById($pagoId);
        if (!$pagoExistente) {
            throw new Exception("El pago con ID {$pagoId} no existe.");
        }

        if ($pagoExistente['estado'] !== "creado") {
            throw new Exception("El estado del pago solo se puede cambiar si es 'creado'.");
        }

        // Validar el estado de pago
        $nuevoEstado = $_POST['estado_pago'] ?? null;
        if (empty($nuevoEstado)) {
            throw new Exception("El estado del pago es requerido.");
        }

        // Actualizar el estado del pago
        $resultado = $pagoRepo->updatePagoState($pagoId, $nuevoEstado);

        if ($resultado && $nuevoEstado === "aprobado") {
            // Buscar al cliente relacionado con el pago
            $cliente = $clienteRepo->findClienteById($pagoExistente['cliente_id']);
            if (!$cliente) {
                throw new Exception("El cliente asociado con el pago no existe.");
            }

            $fullname = $cliente['nombre'] . " " . $cliente['apellido'];
            $cantidadBoletos = (int)$pagoExistente['tiques'];
            $rifaId = (int)$pagoExistente['rifa_id'];

            // Validar que la rifa exista
            $rifaExistente = $rifaRepo->findRifaById($rifaId);
            if (!$rifaExistente) {
                throw new Exception("La rifa con ID {$rifaId} no existe.");
            }

            // Generar boletos únicos
            for ($i = 0; $i < $cantidadBoletos; $i++) {
                $numeroBoleto = $boletosRepo->generateUniqueBoleto($rifaId, $rifaExistente['total_boletos']);
                if (!$numeroBoleto) {
                    throw new Exception("Error al generar los boletos.");
                }

                $boletoData = [
                    'numero_boleto' => $numeroBoleto,
                    'cliente_id' => $pagoExistente['cliente_id'],
                    'rifa_id' => $rifaId,
                    'estado' => 'vendido',
                    'pago_id' => $pagoId,
                ];

                $boletosRepo->insert($boletoData);
            }

            // Preparar y enviar correo
            $asunto = "Tu compra ha sido aprobada";
            $codigoCompra = str_pad($pagoId, 8, '0', STR_PAD_LEFT);
            $codigoEncriptado = UtilEncriptacion::encriptar($codigoCompra);
            $enlace = HOST . 'recibo/' . $codigoEncriptado;
            $correoHTML = CorreoHelper::generarCorreoCompraAprobada($fullname, $codigoCompra, $enlace);

            if (!Mailer::send($cliente['correo'], $asunto, $correoHTML)) {
                throw new Exception("Error al enviar el correo.", 500);
            }
        }

        echo json_encode(["success" => true, "message" => "Pago actualizado correctamente y boletos generados."]);
    } catch (Exception $e) {
        $errorCode = $e->getCode() === 500 ? 500 : 400;
        http_response_code($errorCode);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
