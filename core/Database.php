<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    // Constructeur privé
    private function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';  // `require_once` → `require` (meilleure pratique pour les configs)

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,  // Désactive l'émulation des requêtes préparées
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Empêche le clonage
    private function __clone() {}

    // Récupère l'instance unique (avec retour de type)
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Récupère la connexion PDO (avec retour de type)
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Méthode pour exécuter des requêtes SELECT (retourne un tableau de résultats)
    public function query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Erreur lors de la requête : " . $e->getMessage());
        }
    }

    // Méthode pour exécuter des requêtes INSERT/UPDATE/DELETE (retourne le nombre de lignes affectées)
    public function execute(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            die("Erreur lors de la requête : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer une seule ligne
    public function fetch(string $sql, array $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Erreur lors de la requête : " . $e->getMessage());
        }
    }

    // Récupère l'ID de la dernière insertion
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
