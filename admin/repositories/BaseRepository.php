<?php

class BaseRepository {
    protected $tableName;
    protected $primaryKey = 'id'; // Clave primaria por defecto

    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }

    public function findAll(): array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): bool {
        $db = Database::getConnection();
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($query);
        return $stmt->execute($data);
    }

    public function update($id, array $data): bool {
        $db = Database::getConnection();
        $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $query = "UPDATE {$this->tableName} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $stmt = $db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id): bool {
        $db = Database::getConnection();
        $query = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
