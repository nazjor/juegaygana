<?php

class Database {
    private static $instance = null;

    public static function getConnection(): PDO {
        if (!self::$instance) {
            // Usar las constantes definidas previamente
            self::$instance = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", 
                DB_USER, 
                DB_PASSWORD
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
