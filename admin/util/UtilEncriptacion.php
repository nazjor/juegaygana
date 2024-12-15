<?php
class UtilEncriptacion {

    /**
     * Encripta un dato utilizando base64
     * 
     * @param string $dato El dato a encriptar
     * @return string El dato encriptado en base64
     */
    public static function encriptar($dato) {
        // Encriptar el dato utilizando base64
        return base64_encode($dato);
    }

    /**
     * Desencripta un dato utilizando base64
     * 
     * @param string $datoEncriptado El dato encriptado en base64
     * @return string El dato original
     */
    public static function desencriptar($datoEncriptado) {
        // Desencriptar el dato utilizando base64
        return base64_decode($datoEncriptado);
    }
}

