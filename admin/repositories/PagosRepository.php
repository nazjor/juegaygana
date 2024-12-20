<?php

class PagosRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('pagos'); // Nombre de la tabla en la base de datos
    }

    public function findPagosConPaginacion($limite, $offset, $filtros = []) {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        
        // Definir la base de la consulta
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
            WHERE 1=1"; // Agregar WHERE 1=1 para permitir agregar condiciones dinámicamente
    
        // Agregar filtros si se reciben
        if (!empty($filtros['estado'])) {
            $query .= " AND p.estado = :estado";
        }
        if (!empty($filtros['correo'])) {
            $query .= " AND c.correo LIKE :correo";
        }
        if (!empty($filtros['fechaInicio'])) {
            $query .= " AND p.fecha_pago >= :fechaInicio";
        }
        if (!empty($filtros['fechaFin'])) {
            $query .= " AND p.fecha_pago <= :fechaFin";
        }
    
        // Ordenar por ID y aplicar paginación
        $query .= " ORDER BY p.id DESC LIMIT :limite OFFSET :offset";
        
        // Preparar la consulta
        $stmt = $db->prepare($query);
    
        // Vincular los parámetros de filtro si se proporcionan
        if (!empty($filtros['estado'])) {
            $stmt->bindParam(':estado', $filtros['estado'], PDO::PARAM_STR);
        }
        if (!empty($filtros['correo'])) {
            $correo = '%' . $filtros['correo'] . '%';
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        }
        if (!empty($filtros['titulo'])) {
            $titulo = '%' . $filtros['titulo'] . '%';
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        }
        if (!empty($filtros['fechaInicio'])) {
            $stmt->bindParam(':fechaInicio', $filtros['fechaInicio'], PDO::PARAM_STR);
        }
        if (!empty($filtros['fechaFin'])) {
            $stmt->bindParam(':fechaFin', $filtros['fechaFin'], PDO::PARAM_STR);
        }
    
        // Vincular los parámetros de paginación
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Retornar los resultados
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
    
        // Obtener la fecha actual en formato compatible con MySQL
        $currentDate = date('Y-m-d H:i:s');
    
        // Crear la consulta SQL para insertar, incluyendo el campo fecha_pago
        $query = "INSERT INTO {$this->tableName} 
            (cliente_id, rifa_id, metodo_pago, imagen_pago, monto, tiques, creado_en, fecha_pago)
            VALUES (:cliente_id, :rifa_id, :metodo_pago, :imagen_pago, :monto, :tiques, :creado_en, :fecha_pago)";
    
        $stmt = $db->prepare($query);
    
        // Vincular los valores al statement
        $stmt->bindValue(':cliente_id', $data['cliente_id'], PDO::PARAM_INT);
        $stmt->bindValue(':rifa_id', $data['rifa_id'], PDO::PARAM_INT);
        $stmt->bindValue(':tiques', $data['tiques'], PDO::PARAM_INT);
        $stmt->bindValue(':monto', $data['monto'], PDO::PARAM_STR);
        $stmt->bindValue(':metodo_pago', $data['metodo_pago'], PDO::PARAM_STR);
        $stmt->bindValue(':imagen_pago', $data['imagen_pago'], PDO::PARAM_STR);
        $stmt->bindValue(':creado_en', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':fecha_pago', $currentDate, PDO::PARAM_STR);
    
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