<?php

class RifaRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('rifas'); // Nombre de la tabla en la base de datos
    }

    public function findRifasConPaginacion($limite, $offset) {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        $query = "SELECT * FROM rifas ORDER BY id DESC LIMIT :limite OFFSET :offset"; // Ordenar por id
        $stmt = $db->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contarTotalRifas() {
        $db = Database::getConnection(); // Obtener la conexión a la base de datos
        $query = "SELECT COUNT(*) FROM rifas";
        $result = $db->query($query);
        return $result->fetchColumn();
    }

    /**
     * Busca todas las rifas en la base de datos.
     *
     * @return array Retorna una lista con todas las rifas.
     */
    public function findAllRifas(): array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca rifas por nombre.
     *
     * @param string $nombre El nombre de la rifa.
     * @return array|null Retorna los datos de la rifa o null si no se encuentra.
     */
    public function findByName(string $nombre): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE nombre = :nombre";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Busca una rifa activa.
     *
     * @return array|null Retorna los datos de la rifa activa o null si no existe ninguna.
     */
    public function findActiveRifa(): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE estado = 'activa' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        // Obtener solo una fila
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retornar null si no se encontró ninguna rifa activa
        return $result ?: null;
    }

    /**
     * Actualiza el estado de una rifa.
     *
     * @param int $id El ID de la rifa.
     * @param string $estado El nuevo estado.
     * @return bool Retorna true si la operación fue exitosa.
     */
    public function updateRifaState(int $id, string $estado): bool {
        $db = Database::getConnection();
        $query = "UPDATE {$this->tableName} SET estado = :estado WHERE {$this->primaryKey} = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para insertar una nueva rifa
    public function insertRifa(string $nombre, string $foto, int $boletosMaximos, string $fechaInicio, float $precioBoleto, string $descripcion): bool {
        $db = Database::getConnection();
        $query = "INSERT INTO {$this->tableName} (titulo, imagen_rifa, total_boletos, fecha_inicio, precio_boleto, descripcion) 
                  VALUES (:titulo, :imagen_rifa, :total_boletos, :fecha_inicio, :precio_boleto, :descripcion)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':titulo', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':imagen_rifa', $foto, PDO::PARAM_STR);
        $stmt->bindValue(':total_boletos', $boletosMaximos, PDO::PARAM_INT);
        $stmt->bindValue(':fecha_inicio', $fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(':precio_boleto', $precioBoleto, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR); // Bind de la descripción
        return $stmt->execute();
    }    

    /**
     * Busca una rifa por su ID.
     *
     * @param int $id El ID de la rifa.
     * @return array|null Retorna los datos de la rifa o null si no se encuentra.
     */
    public function findRifaById(int $id): ?array {
        $db = Database::getConnection();
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    public function updateRifa($id, $nombre, $fotoName, $boletosMaximos, $fechaInicioFormatted, $precioBoleto, $descripcion) {
        $db = Database::getConnection();
        
        $query = "UPDATE rifas SET 
                  titulo = :titulo, 
                  imagen_rifa = :imagen_rifa, 
                  total_boletos = :total_boletos, 
                  fecha_inicio = :fecha_inicio, 
                  precio_boleto = :precio_boleto, 
                  descripcion = :descripcion
                  WHERE id = :id";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':imagen_rifa', $fotoName, PDO::PARAM_STR);
        $stmt->bindParam(':total_boletos', $boletosMaximos, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_inicio', $fechaInicioFormatted, PDO::PARAM_STR);
        $stmt->bindParam(':precio_boleto', $precioBoleto, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR); // Bind de la descripción
        
        return $stmt->execute();
    }    
}
