<?php
    session_start();
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/BoletosRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/ClientesRepository.php';
    require_once DIRPAGE_ADMIN . 'repositories/GanadoresRepository.php';
    require_once DIRPAGE_ADMIN . 'util/Mail.php';
    require_once DIRPAGE_ADMIN . 'util/CorreoHelper.php';
    require_once DIRPAGE_ADMIN . 'util/UtilEncriptacion.php';

    $data = json_decode(file_get_contents('php://input'), true);

    try {
        if (!isset($_SESSION['usuario'])) {
            throw new Exception("No autorizado.", 401);
        }
        
        if (!isset($data['numeroGanador'])) {
            throw new Exception("No se proporcionó el numeroGanador.");
        }

        $numeroGanador = (int) $data['numeroGanador'];

        $rifaRepo = new RifaRepository();
        $boletoRepo = new BoletosRepository();
        $clienteRepo = new ClientesRepository();
        $ganadorRepo = new GanadoresRepository();
        $rifaActiva = $rifaRepo->findActiveRifa();

        $boletoGanador = $boletoRepo->findByBoletoAndRifaId($numeroGanador, $rifaActiva['id']);

        $cliente = $clienteRepo->findClienteById($boletoGanador['cliente_id']);

        // Preparar y enviar correo
        $asunto = "Felicidades has ganado en nuestro sorteo";
        $codigoCompra = str_pad($boletoGanador['pago_id'], 8, '0', STR_PAD_LEFT);
        $codigoEncriptado = UtilEncriptacion::encriptar($codigoCompra);
        $enlace = HOST . 'recibo/' . $codigoEncriptado;
        $fullname = $cliente['nombre'] . " " . $cliente['apellido'];
        $correoHTML = CorreoHelper::generarCorreoGanador($fullname, $cliente['telefono'], $rifaActiva['titulo'], $enlace);
        
        $ganadorRepo->insertarGanador($boletoGanador['id']);

        if (!Mailer::send($cliente['correo'], $asunto, $correoHTML)) {
            throw new Exception("Error al enviar el correo.", 500);
        }

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $errorCode = $e->getCode() === 500 ? 500 : 400;
        http_response_code($errorCode);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
