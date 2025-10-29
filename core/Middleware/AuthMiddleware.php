<?php
namespace Core\Middleware;

use App\Models\Auth;

class AuthMiddleware
{
    // Vérifie que l'utilisateur est connecté
    public static function requireLogin(): void
    {
        if (!Auth::isLoggedIn()) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
            header('Location: /login');
            exit;
        }
    }

    // Vérifie que l'utilisateur est propriétaire du trajet ou admin
    public static function requireTrajetOwner(int $trajetId): void
    {
        self::requireLogin(); // Vérifie d'abord que l'utilisateur est connecté

        $trajet = \App\Models\Trajet::find($trajetId);
        if (!$trajet || ($trajet['user_id'] !== $_SESSION['user_id'] && !Auth::isAdmin())) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à accéder à ce trajet.";
            header('Location: /');
            exit;
        }
    }

    // Vérifie que l'utilisateur est admin
    public static function requireAdmin(): void
    {
        if (!Auth::isAdmin()) {
            $_SESSION['error'] = "Accès réservé aux administrateurs.";
            header('Location: /');
            exit;
        }
    }
}
