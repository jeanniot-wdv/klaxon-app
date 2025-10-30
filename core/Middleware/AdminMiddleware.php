<?php
namespace Core\Middleware;

use App\Models\Auth;

class AdminMiddleware
{
    public static function requireAdmin(): void
    {
        if (!Auth::isLoggedIn() || !Auth::isAdmin()) {
            $_SESSION['error'] = "Accès réservé aux administrateurs.";
            header('Location: /');
            exit;
        }
    }
}
