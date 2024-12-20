<?php

class GanadoresRepository extends BaseRepository {

    public function __construct() {
        parent::__construct('ganadores');
    }

    public function findGanadorById(int $id): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Método para contar los ganadores de una rifa específica
    public function countGanadoresByRifaId(int $rifaId): int {
        $db = Database::getConnection();
        $query = "
            SELECT COUNT(*) 
            FROM ganadores
            LEFT JOIN boletos ON boletos.id = ganadores.boleto_id
            LEFT JOIN rifas ON rifas.id = boletos.rifa_id
            WHERE rifas.id = :rifa_id";
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(':rifa_id', $rifaId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Devuelve el total de ganadores
        return (int) $stmt->fetchColumn();
    }

    public function contarTotalGanador() {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        $query = "SELECT COUNT(*) FROM {$this->tableName}";
        $result = $db->query($query);
        return $result->fetchColumn();
    }

   // Obtener los ganadores con JOIN y paginación
    public function getGanadoresConPaginacion($limite, $offset) {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        $query = "
            SELECT ganadores.*, clientes.cedula, clientes.correo, rifas.titulo , boletos.numero_boleto
            FROM ganadores
            LEFT JOIN boletos ON ganadores.boleto_id = boletos.id
            LEFT JOIN clientes ON clientes.id = boletos.cliente_id
            LEFT JOIN rifas ON boletos.rifa_id = rifas.id
            ORDER BY ganadores.id DESC
            LIMIT :limite OFFSET :offset
        ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateImageGanador(int $id, string $imageUrl): bool {
        $db = Database::getConnection();
        $query = "
            UPDATE {$this->tableName} 
            SET imagen_ganador = :imagen_ganador
            WHERE id = :id
        ";
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':imagen_ganador', $imageUrl, PDO::PARAM_STR);
        
        // Ejecutar la consulta y retornar true si se actualizó correctamente
        return $stmt->execute();
    }    

    // Método para insertar un nuevo ganador con el campo `premio`
    public function insertarGanador(int $boleto_id, string $premio): ?int {
        $db = Database::getConnection();

        // Obtener la fecha actual en formato compatible con MySQL
        $currentDate = date('Y-m-d H:i:s');

        // Crear la consulta SQL para insertar
        $query = "INSERT INTO {$this->tableName} (boleto_id, premio, creado_en) VALUES (:boleto_id, :premio, :creado_en)";
        $stmt = $db->prepare($query);

        // Vincular los valores al statement
        $stmt->bindValue(':boleto_id', $boleto_id, PDO::PARAM_INT);
        $stmt->bindValue(':premio', $premio, PDO::PARAM_STR);
        $stmt->bindValue(':creado_en', $currentDate, PDO::PARAM_STR);

        // Ejecutar y verificar si se realizó correctamente
        if ($stmt->execute()) {
            return (int)$db->lastInsertId(); // Devolver el ID del ganador insertado
        } else {
            return null; // Retornar null si falla
        }
    }

    public function obtenerUltimos15Ganadores(): array {
        $db = Database::getConnection();
        $query = "
            SELECT ganadores.*, clientes.cedula, clientes.correo, clientes.nombre, rifas.titulo , boletos.numero_boleto
            FROM ganadores
            LEFT JOIN boletos ON ganadores.boleto_id = boletos.id
            LEFT JOIN clientes ON clientes.id = boletos.cliente_id
            LEFT JOIN rifas ON boletos.rifa_id = rifas.id
            WHERE ganadores.imagen_ganador != ''
            ORDER BY ganadores.creado_en DESC
            LIMIT 15
        ";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
