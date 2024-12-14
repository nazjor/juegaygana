<?php

session_start();

try {
    require_once __DIR__ . '../../../conf/config.php';
    require_once DIRPAGE_ADMIN . 'config/Database.php';
    require_once DIRPAGE_ADMIN . 'repositories/BaseRepository.php';
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
            echo 'success';
            exit;
        } else {
            // Si el login falla
            echo 'error';
            exit;
        }
    }
} catch (Exception $e) {
    // Manejo de errores o excepciones
    error_log('Error en el inicio de sesión: ' . $e->getMessage());
    echo 'error';
    exit;
}