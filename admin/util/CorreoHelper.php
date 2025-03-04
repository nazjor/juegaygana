<?php
class CorreoHelper {
    public static function generarCorreo($firstName, $lastName, $email, $monto, $tiques, $address, $phone, $imagen_pago) {
        $logoUrl = HOST.'assets/images/logo.png';
        $correoHTML = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='width: 600px; margin: 0 auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                    <div style='background-color:#002A40; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
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

    public static function generarCorreoCompraAprobada($nombre, $codigoCompra, $enlaceRecibo) {
        $logoUrl = HOST.'assets/images/logo.png';
        $correoHTML = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='width: 600px; margin: 0 auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                    <div style='background-color: #002A40; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                        <img src='$logoUrl' alt='Logo' style='width: 100px;'>
                        <h2 style='margin-top: 10px;'>¡Compra aprobada!</h2>
                    </div>
                    <div style='padding: 20px;'>
                        <p>¡Felicidades <strong>$nombre</strong>!</p>
                        <p>Tu compra <strong>[$codigoCompra]</strong> ha sido aprobada.</p>
                        <p>Puedes consultar tus boletos en el siguiente enlace. Asegúrate de no compartirlo con nadie:</p>
                        <p style='text-align: center; margin: 20px 0;'>
                            <a href='$enlaceRecibo' style='display: inline-block; background-color: #002A40; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Ver boletos</a>
                        </p>
                        <p style='font-size: 0.9em; color: #888;'>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        return $correoHTML;
    }

    public static function generarCorreoGanador($nombre, $telefono, $premio, $enlaceRecibo) {
        $logoUrl = HOST.'assets/images/logo.png';
        $correoHTML = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='width: 600px; margin: 0 auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                    <div style='background-color:#002A40; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                        <img src='$logoUrl' alt='Logo' style='width: 100px;'>
                        <h2 style='margin-top: 10px;'>¡Felicidades, tenemos un ganador!</h2>
                    </div>
                    <div style='padding: 20px;'>
                        <p>¡Felicidades <strong>$nombre</strong>!</p>
                        <p>Tu número ha salido ganador en nuestra rifa.</p>
                        <p><strong>Datos del ganador:</strong></p>
                        <ul>
                            <li><strong>Nombre:</strong> $nombre</li>
                            <li><strong>Teléfono:</strong> $telefono</li>
                            <li><strong>Premio:</strong> $premio</li>
                        </ul>
                        <p>Puedes consultar el detalle de tu recibo en el siguiente enlace:</p>
                        <p style='text-align: center; margin: 20px 0;'>
                            <a href='$enlaceRecibo' style='display: inline-block; background-color: #002A40; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Ver recibo</a>
                        </p>
                        <p style='font-size: 0.9em; color: #888;'>Si tienes alguna pregunta, no dudes en contactarnos. ¡Gracias por participar!</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        return $correoHTML;
    }    

    public static function generarCorreoCompraPendiente($nombre) {
        $logoUrl = HOST.'assets/images/logo.png';
        $correoHTML = "
            <html>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='width: 600px; margin: 0 auto; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                    <div style='background-color:#002A40; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                        <img src='$logoUrl' alt='Logo' style='width: 100px;'>
                        <h2 style='margin-top: 10px;'>Compra en proceso</h2>
                    </div>
                    <div style='padding: 20px;'>
                        <p>¡Hola <strong>$nombre</strong>!</p>
                        <p>Se ha realizado tu compra correctamente. Por favor, espera mientras confirmamos tu pago.</p>
                        <p>Recibirás un correo con los boletos de tu compra una vez que el proceso esté completo.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        return $correoHTML;
    }    
}
?>
