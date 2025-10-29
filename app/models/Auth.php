<?php

namespace App\Models;

use App\Models\User;

class Auth
{
  // Connecte un utilisateur
  public static function login(string $email, string $password): ?array
  {
    $user = User::findByEmail($email);

    // Vérifie que l'utilisateur existe et que le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
      // Régénère l'ID de session pour éviter les attaques de fixation de session
      session_regenerate_id(true);

      // Définit les variables de session
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
    // Supprime toutes les variables de session
    $_SESSION = [];

    // Détruit la session
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
  }

  // Vérifie si l'utilisateur est connecté
  public static function isLoggedIn(): bool
  {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
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
