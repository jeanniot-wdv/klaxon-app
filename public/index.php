<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\HomeController;

// Initialiser le router
$router = new Router();

// Définir les routes
$router->add('/', HomeController::class, 'index');
$router->add('/trajets/contact/{id}', \App\Controllers\TrajetController::class, 'contact');
$router->add('/trajets/send-message/{id}', \App\Controllers\TrajetController::class, 'sendMessage', ['POST']);
$router->add('/agences/{id}', \App\Controllers\AgenceController::class, 'show');
$router->add('/agences', \App\Controllers\AgenceController::class, 'index');

// $router->add('/trajets/{id}', \App\Controllers\TrajetController::class, 'show');
// $router->add('/trajets/recherche', \App\Controllers\TrajetController::class, 'search');


// Récupérer l'URL actuelle
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Trouver la route correspondante
try {
    $route = $router->match($url);
    $controller = new $route['controller'];

    // Passe les paramètres à la méthode
    if (!empty($route['params'])) {
        call_user_func_array([$controller, $route['method']], $route['params']);
    } else {
        $controller->{$route['method']}();
    }
} catch (\Exception $e) {
    header("HTTP/1.0 404 Not Found");
    echo "Erreur: " . $e->getMessage();
    // Ou inclure une vue 404: include __DIR__ . '/../app/views/errors/404.php';
}
