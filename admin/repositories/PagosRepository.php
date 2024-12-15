<?php

class PagosRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('pagos'); // Nombre de la tabla en la base de datos
    }

    public function findPagosConPaginacion($limite, $offset) {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
    
        // Realizamos el JOIN entre las tablas pagos, clientes y rifas
        $query = "
            SELECT 
                p.*,
                c.correo, 
                r.titulo
            FROM 
                {$this->tableName} p 
            LEFT JOIN 
                clientes c ON p.cliente_id = c.id 
            LEFT JOIN 
                rifas r ON p.rifa_id = r.id 
            ORDER BY 
                p.id DESC 
            LIMIT :limite OFFSET :offset
        ";
    
        $stmt = $db->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contarTotalPagos() {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        $query = "SELECT COUNT(*) FROM {$this->tableName}";
        $result = $db->query($query);
        return $result->fetchColumn();
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
    
        try {
            // Crear la consulta SQL para obtener el total de boletos
            $query = "SELECT SUM(tiques) AS total_boletos 
                      FROM {$this->tableName} 
                      WHERE rifa_id = :rifa_id AND estado <> :estado";
    
            $stmt = $db->prepare($query);
            $stmt->bindValue(':rifa_id', $rifa_id, PDO::PARAM_INT);
            $stmt->bindValue(':estado', 'anulado', PDO::PARAM_STR);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Retornar el total de boletos, si no hay resultados, retornar 0
            return (int)($result['total_boletos'] ?? 0);
        } catch (PDOException $e) {
            // Manejo de errores, podrías registrar el error en un log o lanzar una excepción
            error_log("Error al obtener el total de boletos: " . $e->getMessage());
            return 0;
        }
    }    

    public function findPagoById(int $id): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updatePagoState(int $id, string $estado): bool {
        $db = Database::getConnection();
        $query = "UPDATE {$this->tableName} SET estado = :estado WHERE {$this->primaryKey} = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


}