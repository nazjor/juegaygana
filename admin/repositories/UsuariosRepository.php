<?php

class UsuariosRepository extends BaseRepository {

    public function __construct() {
        parent::__construct('usuarios'); // Nombre de la tabla en la base de datos
    }

    // Método para encontrar un usuario por su correo
    public function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE correo = :email";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

}
?>
