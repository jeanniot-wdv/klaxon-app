<?php
namespace App\Models;

use Core\Database;

class User
{
    // Récupère un utilisateur par son email
    public static function findByEmail(string $email): ?array
    {
        $db = Database::getInstance();
        return $db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
    }

    // Récupère un utilisateur par son ID
    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        return $db->fetch("SELECT * FROM users WHERE id = ?", [$id]);
    }

    // Crée un nouvel utilisateur
    public static function create(string $nom, string $prenom, string $email, string $password): bool
    {
        $db = Database::getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $db->execute(
            "INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?)",
            [$nom, $prenom, $email, $hashedPassword]
        );
    }

    // Vérifie si un email existe déjà
    public static function emailExists(string $email): bool
    {
        $db = Database::getInstance();
        $user = $db->fetch("SELECT id FROM users WHERE email = ?", [$email]);
        return $user !== false;
    }

    // Vérifie le mot de passe
    public static function verifyPassword(string $email, string $password): bool
    {
        $user = self::findByEmail($email);
        return $user && password_verify($password, $user['password']);
    }

    // Vérifie si l'utilisateur est admin
    public static function isAdmin(int $userId): bool
    {
        $db = Database::getInstance();
        $user = $db->fetch("SELECT role FROM users WHERE id = ?", [$userId]);
        return $user && $user['role'] === 'admin';
    }

    // Met à jour les informations d'un utilisateur
    public static function update(int $id, string $nom, string $prenom, string $email, ?string $password = null): bool
    {
        $db = Database::getInstance();
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return $db->execute(
                "UPDATE users SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?",
                [$nom, $prenom, $email, $hashedPassword, $id]
            );
        } else {
            return $db->execute(
                "UPDATE users SET nom = ?, prenom = ?, email = ? WHERE id = ?",
                [$nom, $prenom, $email, $id]
            );
        }
    }
}
