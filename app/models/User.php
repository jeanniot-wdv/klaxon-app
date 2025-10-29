<?php
namespace App\Models;

use Core\Database;

class User
{
    // Récupère un utilisateur par son ID
    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        return $db->fetch("SELECT * FROM users WHERE id = ?", [$id]);
    }

    // Vérifie si l'utilisateur est admin
    public static function isAdmin(int $userId): bool
    {
        $db = Database::getInstance();
        $user = $db->fetch("SELECT role FROM users WHERE id = ?", [$userId]);
        return $user && $user['role'] === 'admin';
    }

    // Récupère tous les utilisateurs (réservé aux admins)
    public static function all(): array
    {
        $db = Database::getInstance();
        return $db->query("SELECT * FROM users ORDER BY nom, prenom");
    }
}
