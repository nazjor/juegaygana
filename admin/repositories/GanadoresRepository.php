<?php

class GanadoresRepository extends BaseRepository {

    public function __construct() {
        parent::__construct('ganadores');
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

    // Método para obtener todos los ganadores
    public function obtenerGanadores(): array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Método para insertar un nuevo ganador con el campo `premio`
    public function insertarGanador(int $boleto_id, string $premio): ?int {
        $db = Database::getConnection();
        $query = "INSERT INTO {$this->tableName} (boleto_id, premio, creado_en) VALUES (:boleto_id, :premio, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':boleto_id', $boleto_id, PDO::PARAM_INT);
        $stmt->bindValue(':premio', $premio, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return null;
        }
    }
}
?>
