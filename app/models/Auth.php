<?php
namespace App\Models;

class Auth
{
    // Connecte un utilisateur
    public static function login(string $email, string $password): ?array
    {
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // Protège contre les fixes de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_role'] = $user['role'];
            return $user;
        }
        return null;
    }

    // Déconnecte l'utilisateur
    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    // Vérifie si l'utilisateur est connecté
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    // Récupère l'utilisateur connecté
    public static function getUser(): ?array
    {
        if (self::isLoggedIn()) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }

    // Vérifie si l'utilisateur est admin
    public static function isAdmin(): bool
    {
        return self::isLoggedIn() && ($_SESSION['user_role'] ?? '') === 'admin';
    }
}
