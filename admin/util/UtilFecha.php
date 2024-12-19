<?php
class UtilFecha {

/**
 * Convierte una fecha en formato 'YYYY-MM-DD' a un formato legible.
 * 
 * @param string $fecha_inicio La fecha en formato 'YYYY-MM-DD'.
 * @return string La fecha formateada en formato 'd de M, Y'.
 */
public static function formatearFecha($fecha_inicio) {
    $meses = [
        1 => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio',
        '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
    ];

    // Crear un objeto DateTime a partir de la fecha
    $fecha = new DateTime($fecha_inicio);
    
    // Obtener el día, mes y año
    $dia = $fecha->format('d');
    $mes = $meses[(int)$fecha->format('m')];
    $año = $fecha->format('Y');
    
    // Retornar la fecha formateada
    return "$dia de $mes, $año";
}
}
