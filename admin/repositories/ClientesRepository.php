<?php

class ClientesRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('clientes'); // Nombre de la tabla en la base de datos
    }

    // Métodos específicos para la entidad Cliente
    public function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
