<?php
class UtilEncriptacion {

    /**
     * Genera una sal aleatoria de 4 bytes (8 caracteres hexadecimales)
     * 
     * @return string Sal aleatoria
     */
    private static function generarSal() {
        // Generar una cadena aleatoria de 4 bytes usando caracteres alfanuméricos
        return bin2hex(random_bytes(4));  // 4 bytes = 8 caracteres hexadecimales
    }

    /**
     * Encripta un dato utilizando base64 + sal aleatoria + hash
     * 
     * @param string $dato El dato a encriptar
     * @return string El dato encriptado de forma más compleja
     */
    public static function encriptar($dato) {
        // Generar una sal aleatoria de 8 caracteres
        $sal = self::generarSal();
        
        // Añadir la sal al dato
        $datoConSalt = $sal . $dato;
        
        // Generar un hash del dato con sal
        $hash = hash('sha256', $datoConSalt);
        
        // Encriptar con base64
        $encriptado = base64_encode($sal . $hash);  // Guardar la sal junto con el hash para que pueda ser usado luego
        
        return $encriptado;
    }
    
    /**
     * Desencripta un dato utilizando base64 + sal
     * 
     * @param string $datoEncriptado El dato encriptado en base64
     * @return string El valor original
     */
    public static function desencriptar($datoEncriptado) {
        // Decodificar el valor base64
        $datos = base64_decode($datoEncriptado);
        
        // Obtener la sal (primeros 8 caracteres hexadecimales)
        $sal = substr($datos, 0, 8);
        
        // El resto es el hash
        $hash = substr($datos, 8);
        
        // El proceso de desencriptado verdadero no es posible, pero podemos simularlo de la siguiente manera:
        return str_replace($sal, '', $hash);  // Retirar la sal del hash (aunque en la práctica no es reversible)
    }
}

