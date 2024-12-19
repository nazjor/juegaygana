<?php

class BoletosRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('boletos'); // Nombre de la tabla en la base de datos
    }

    // Método para encontrar boletos por idPago
    public function findByPagoId(int $pagoId): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE pago_id = :pago_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':pago_id', $pagoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    // Método para contar el total de boletos vendidos por rifa_id
    public function countBoletosVendidosByRifaId(int $rifaId): int {
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) FROM {$this->tableName} WHERE rifa_id = :rifa_id AND estado = 'vendido'";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rifa_id', $rifaId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Devuelve el total de boletos vendidos
        return (int) $stmt->fetchColumn();
    }


    // Método para insertar un boleto
    public function insert(array $data): int {
        $db = Database::getConnection();
    
        // Crear la consulta SQL para insertar
        $query = "INSERT INTO {$this->tableName} 
            (numero_boleto, cliente_id, rifa_id, estado, pago_id, creado_en, actualizado_en)
            VALUES (:numero_boleto, :cliente_id, :rifa_id, :estado, :pago_id, :creado_en, :actualizado_en)";
    
        $stmt = $db->prepare($query);
    
        // Vincular los valores al statement
        $stmt->bindValue(':numero_boleto', $data['numero_boleto'], PDO::PARAM_INT);
        $stmt->bindValue(':cliente_id', $data['cliente_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':rifa_id', $data['rifa_id'], PDO::PARAM_INT);
        $stmt->bindValue(':estado', $data['estado'] ?? 'vendido', PDO::PARAM_STR);
        $stmt->bindValue(':pago_id', $data['pago_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':creado_en', $data['creado_en'] ?? date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':actualizado_en', $data['actualizado_en'] ?? date('Y-m-d H:i:s'), PDO::PARAM_STR);
    
        // Ejecutar y verificar si se realizó correctamente
        if ($stmt->execute()) {
            return (int)$db->lastInsertId(); // Devolver el ID del boleto insertado
        } else {
            throw new Exception("Error al insertar el boleto: " . implode(", ", $stmt->errorInfo()));
        }
    }
    
    // Método para generar un número de boleto aleatorio
    public function generateUniqueBoleto(int $rifaId, int $max = 9999): int {
        $db = Database::getConnection();
        do {
            $numeroBoleto = random_int(0, $max);
            $query = "SELECT COUNT(*) FROM {$this->tableName} WHERE rifa_id = :rifa_id AND numero_boleto = :numero_boleto";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':rifa_id', $rifaId, PDO::PARAM_INT);
            $stmt->bindValue(':numero_boleto', $numeroBoleto, PDO::PARAM_INT);
            $stmt->execute();
            $exists = $stmt->fetchColumn() > 0;
        } while ($exists);

        return $numeroBoleto;
    }

    /**
     * Obtiene un boleto aleatorio con estado 'vendido' para una rifa específica.
     *
     * @param int $rifaId El ID de la rifa.
     * @return array|null El boleto encontrado o null si no se encuentra ninguno.
     */
    public function findRandomVendidoByRifaId(int $rifaId): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} 
                  WHERE rifa_id = :rifa_id AND estado = 'vendido' 
                  ORDER BY RAND() LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rifa_id', $rifaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Método para encontrar un boleto por numero_boleto y rifa_id
    public function findByBoletoAndRifaId(int $numeroBoleto, int $rifaId): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} 
                WHERE numero_boleto = :numero_boleto AND rifa_id = :rifa_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':numero_boleto', $numeroBoleto, PDO::PARAM_INT);
        $stmt->bindValue(':rifa_id', $rifaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
