<?php

class PagosRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('pagos'); // Nombre de la tabla en la base de datos
    }

    // Método para insertar un nuevo pago
    public function insert(array $data): int {
        $db = Database::getConnection();

        // Crear la consulta SQL para insertar
        $query = "INSERT INTO {$this->tableName} 
            (cliente_id, rifa_id, metodo_pago, imagen_pago, monto, tiques, creado_en)
            VALUES (:cliente_id, :rifa_id, :metodo_pago, :imagen_pago, :monto, :tiques, NOW())";

        $stmt = $db->prepare($query);

        // Vincular los valores al statement
        $stmt->bindValue(':cliente_id', $data['cliente_id'], PDO::PARAM_INT);
        $stmt->bindValue(':rifa_id', $data['rifa_id'], PDO::PARAM_INT);
        $stmt->bindValue(':tiques', $data['tiques'], PDO::PARAM_INT);
        $stmt->bindValue(':monto', $data['monto'], PDO::PARAM_STR);
        $stmt->bindValue(':metodo_pago', $data['metodo_pago'], PDO::PARAM_STR);
        $stmt->bindValue(':imagen_pago', $data['imagen_pago'], PDO::PARAM_STR);

        // Ejecutar y verificar si se realizó correctamente
        if ($stmt->execute()) {
            return (int)$db->lastInsertId(); // Devolver el ID del pago insertado
        } else {
            throw new Exception("Error al insertar el pago: " . implode(", ", $stmt->errorInfo()));
        }
    }
}