<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AgenceController;
use App\Controllers\TrajetController;
use App\Controllers\ErrorController;

// Initialiser le router
$router = new Router();

// Définir les routes
$router->add('/', HomeController::class, 'index');
$router->add('/trajets', TrajetController::class, 'index');
$router->add('/trajets/contact/{id}', TrajetController::class, 'contact');
$router->add('/trajets/send-message/{id}', TrajetController::class, 'sendMessage', ['POST']);
$router->add('/agences', AgenceController::class, 'index');
$router->add('/agences/{id}', AgenceController::class, 'show');

// $router->add('/trajets/{id}', \App\Controllers\TrajetController::class, 'show');
// $router->add('/trajets/recherche', \App\Controllers\TrajetController::class, 'search');

// Routes d'erreur
$router->add('/404', ErrorController::class, 'notFound');
$router->add('/403', ErrorController::class, 'forbidden');


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
    error_log($e->getMessage());
    // Rediriger vers une page 404
    header("HTTP/1.0 404 Not Found");
    (new ErrorController())->notFound();
    exit;
}
