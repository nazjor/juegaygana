<?php

class GanadoresRepository extends BaseRepository {

    public function __construct() {
        parent::__construct('ganadores');
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
