<?php

session_start();

header('Content-Type: application/json'); // Aseguramos que la respuesta sea JSON

try {
    require_once __DIR__ . '../../components/init.php';
    require_once DIRPAGE_ADMIN . 'repositories/UsuariosRepository.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Instanciamos el repositorio de usuarios
        $usuariosRepo = new UsuariosRepository();

        // Buscar usuario por correo
        $usuario = $usuariosRepo->findByEmail($email);

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($usuario && password_verify($password, $usuario['contraseña'])) {
            // Iniciar sesión
            $_SESSION['usuario'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];

            // Responder éxito
            http_response_code(200); // Código HTTP de éxito
            echo json_encode(["message" => "Inicio de sesión exitoso"]);
            exit;
        } else {
            // Si el login falla
            http_response_code(401); // Código HTTP de no autorizado
            echo json_encode(["message" => "Credenciales incorrectas"]);
            exit;
        }
    } else {
        // Si no es un método POST
        http_response_code(405); // Código HTTP de método no permitido
        echo json_encode(["message" => "Método no permitido"]);
        exit;
    }
} catch (Exception $e) {
    // Manejo de errores o excepciones
    error_log('Error en el inicio de sesión: ' . $e->getMessage());
    http_response_code(500); // Código HTTP de error interno del servidor
    echo json_encode(["message" => "Error interno del servidor"]);
    exit;
}
