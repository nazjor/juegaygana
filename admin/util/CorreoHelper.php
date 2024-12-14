<?php
class CorreoHelper {
    public static function generarCorreo($firstName, $lastName, $email, $monto, $tiques, $address, $phone, $imagen_pago) {
        $logoUrl = HOST.'assets/images/logo.png';
        $correoHTML = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='width: 600px; margin: 0 auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                    <div style='background-color: #333; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                        <img src='$logoUrl' alt='Logo' style='width: 100px;'>
                        <h2 style='margin-top: 10px;'>Nuevo pago recibido</h2>
                    </div>
                    <div style='padding: 20px;'>
                        <p>Se ha realizado una nueva compra. Aquí están los detalles:</p>
                        <ul style='list-style: none; padding: 0;'>
                            <li><strong>Nombre:</strong> $firstName $lastName</li>
                            <li><strong>Email:</strong> $email</li>
                            <li><strong>Monto:</strong> $$monto</li>
                            <li><strong>Cantidad de boletos:</strong> $tiques</li>
                            <li><strong>Dirección:</strong> $address</li>
                            <li><strong>Teléfono:</strong> $phone</li>
                        </ul>
                        <p><strong>Imagen del pago:</strong></p>
                        <img src='$imagen_pago' alt='Imagen de pago' style='width: 100%; height: auto; border-radius: 5px;' />
                    </div>
                </div>
            </body>
            </html>
        ";
        return $correoHTML;
    }
}
?>
