<?php
class UtilEncriptacion {

    // Clave secreta para encriptar/desencriptar
    private static $clave = KEY_ENCRIPT;
    
    /**
     * Encripta un valor utilizando AES-128-CBC con un IV aleatorio.
     * 
     * @param string $dato El dato a encriptar
     * @return string El valor encriptado junto con el IV
     */
    public static function encriptar($dato) {
        // Generar un IV aleatorio de 16 bytes
        $iv = openssl_random_pseudo_bytes(16);
        
        // Encriptar el dato con el IV aleatorio
        $encriptado = openssl_encrypt($dato, 'aes-128-cbc', self::$clave, 0, $iv);
        
        // Verificar si la encriptación fue exitosa
        if ($encriptado === false) {
            throw new Exception('Error al encriptar el dato.');
        }
        
        // Retornar el valor encriptado junto con el IV (en base64, para facilitar su almacenamiento)
        return base64_encode($iv . $encriptado);
    }
    
    /**
     * Desencripta un valor encriptado con AES-128-CBC y un IV aleatorio.
     * 
     * @param string $datoEncriptado El dato encriptado a desencriptar
     * @return string El valor original
     */
    public static function desencriptar($datoEncriptado) {
        // Decodificar el valor de base64
        $data = base64_decode($datoEncriptado);
        
        // Verificar si la decodificación fue exitosa
        if ($data === false) {
            throw new Exception('Error al decodificar el dato.');
        }
        
        // Obtener el IV (primeros 16 bytes)
        $iv = substr($data, 0, 16);
        
        // Obtener el dato encriptado (resto del valor)
        $datoEncriptado = substr($data, 16);
        
        // Desencriptar el dato con el IV
        $desencriptado = openssl_decrypt($datoEncriptado, 'aes-128-cbc', self::$clave, 0, $iv);
        
        // Verificar si la desencriptación fue exitosa
        if ($desencriptado === false) {
            throw new Exception('Error al desencriptar el dato.');
        }
        
        // Retornar el valor desencriptado
        return $desencriptado;
    }
}
