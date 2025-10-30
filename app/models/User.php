<?php

namespace App\Models;

use Core\Database;

class User
{
  // Récupère tous les utilisateurs
  public static function all(): array
  {
    $db = Database::getInstance();
    return $db->query("SELECT * FROM users ORDER BY nom, prenom");
  }

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

  // Crée un nouvel utilisateur
  public static function create(string $nom, string $prenom, string $email, string $password, string $role = 'user'): bool
  {
    $db = Database::getInstance();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $db->execute(
      "INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)",
      [$nom, $prenom, $email, $hashedPassword, $role]
    );
  }

  // Met à jour un utilisateur
  public static function update(int $id, string $nom, string $prenom, string $email, ?string $password = null, string $role = 'user'): bool
  {
    $db = Database::getInstance();
    if ($password) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      return $db->execute(
        "UPDATE users SET nom = ?, prenom = ?, email = ?, password = ?, role = ? WHERE id = ?",
        [$nom, $prenom, $email, $hashedPassword, $role, $id]
      );
    } else {
      return $db->execute(
        "UPDATE users SET nom = ?, prenom = ?, email = ?, role = ? WHERE id = ?",
        [$nom, $prenom, $email, $role, $id]
      );
    }
  }
  // Supprime un utilisateur
  public static function delete(int $id): bool
  {
    $db = Database::getInstance();
    return $db->execute("DELETE FROM users WHERE id = ?", [$id]);
  }
}
