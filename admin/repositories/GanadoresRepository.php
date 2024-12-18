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

    // Método para insertar un nuevo ganador
    public function insertarGanador(int $boleto_id): ?int {
        $db = Database::getConnection();
        $query = "INSERT INTO {$this->tableName} (boleto_id, creado_en) VALUES (:boleto_id, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':boleto_id', $boleto_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return null;
        }
    }
}

?>
