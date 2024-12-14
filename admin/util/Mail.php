<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require DIRPAGE.'vendor/autoload.php';

class Mailer {
    // Métodos estáticos para enviar correo
    public static function send($to, $subject, $body, $from = MAIL_FROM, $fromName = 'Empresa') {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com'; // Servidor SMTP de Hostinger
            $mail->SMTPAuth   = true;                 
            $mail->Username   = $from; // Tu dirección de correo
            $mail->Password   = MAIL_PASSWORD;        // Contraseña de tu correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usa SSL
            $mail->Port       = 465;                   // Puerto SMTP (465 para SSL, 587 para TLS)

            // Configuración del correo
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to); // Correo y nombre del destinatario

            // Contenido del correo
            $mail->isHTML(true);                      // Habilitar HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body); // Texto alternativo en caso de no soportar HTML

            // Enviar correo
            $mail->send();
            return true; // Correo enviado exitosamente
        } catch (Exception $e) {
            return "No se pudo enviar el correo. Error: {$mail->ErrorInfo}"; // Error de envío
        }
    }
}
