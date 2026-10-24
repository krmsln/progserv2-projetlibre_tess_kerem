<?php

class Database {
    const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../config/database.ini';

    private PDO $pdo;

    public function __construct() {
        $config = parse_ini_file(self::DATABASE_CONFIGURATION_FILE, true);

        if (!$config) {
            throw new Exception("Erreur lors de la lecture du fichier de configuration : " . self::DATABASE_CONFIGURATION_FILE);
        }

        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        $this->pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
            $username,
            $password
        );
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
