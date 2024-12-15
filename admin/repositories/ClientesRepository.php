<?php

class ClientesRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('clientes'); // Nombre de la tabla en la base de datos
    }

    // Método para encontrar un cliente por correo
    public function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE correo = :correo";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':correo', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
   
    public function findClienteById(int $id): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    // Método para insertar un cliente
    public function insert(array $data): int {
        $db = Database::getConnection();
        
        // Crear la consulta SQL para insertar
        $query = "INSERT INTO {$this->tableName} 
            (nombre, apellido, telefono, correo, direccion, creado_en, actualizado_en)
            VALUES (:nombre, :apellido, :telefono, :correo, :direccion, NOW(), NOW())";

        $stmt = $db->prepare($query);

        // Vincular los valores al statement
        $stmt->bindValue(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':apellido', $data['apellido'], PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $data['telefono'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':correo', $data['correo'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':direccion', $data['direccion'], PDO::PARAM_STR);

        // Ejecutar y verificar si se realizó correctamente
        if ($stmt->execute()) {
            return (int)$db->lastInsertId(); // Devolver el ID del cliente insertado
        } else {
            throw new Exception("Error al insertar el cliente: " . implode(", ", $stmt->errorInfo()));
        }
    }
}
