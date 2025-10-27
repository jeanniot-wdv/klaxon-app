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

// $router->add('/agences/{id}', \App\Controllers\AgenceController::class, 'show');
// $router->add('/trajets/{id}', \App\Controllers\TrajetController::class, 'show');
// $router->add('/trajets/recherche', \App\Controllers\TrajetController::class, 'search');
// $router->add('/agences', \App\Controllers\AgenceController::class, 'index');


// Récupérer l'URL actuelle
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Trouver la route correspondante
try {
    $route = $router->match($url);

    // Instancier le contrôleur et appeler la méthode
    $controller = new $route['controller'];
    $controller->{$route['method']}();
} catch (Exception $e) {
    echo $e->getMessage();
}