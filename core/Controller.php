<?php
namespace Core;

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Démarrer la temporisation de sortie
        ob_start();

        // Inclure la vue demandée
        require_once __DIR__ . "/../app/views/{$view}.php";

        // Récupérer le contenu et nettoyer le buffer
        $content = ob_get_clean();

        // Inclure le layout principal
        require_once __DIR__ . "/../app/views/layouts/header.php";
        echo $content;
        require_once __DIR__ . "/../app/views/layouts/footer.php";
    }
}
