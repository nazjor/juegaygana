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

    // Método para obtener el total de boletos comprados por rifa_id
    public function getTotalBoletosByRifaId(int $rifa_id): int {
        $db = Database::getConnection();

        // Crear la consulta SQL para obtener el total de boletos
        $query = "SELECT SUM(tiques) AS total_boletos 
                  FROM {$this->tableName} 
                  WHERE rifa_id = :rifa_id";

        $stmt = $db->prepare($query);
        $stmt->bindValue(':rifa_id', $rifa_id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornar el total de boletos, si no hay resultados, retornar 0
        return $result['total_boletos'] ?? 0;
    }
}