<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

// Initialiser le router
$router = new Router();

// Routes publiques
$router->add('/', \App\Controllers\HomeController::class, 'index');
$router->add('/trajets', \App\Controllers\TrajetController::class, 'index');
$router->add('/trajets/recherche', \App\Controllers\TrajetController::class, 'search');
$router->add('/agences', \App\Controllers\AgenceController::class, 'index');
$router->add('/agences/{id}', \App\Controllers\AgenceController::class, 'show');

// Routes pour l'authentification
$router->add('/login', \App\Controllers\AuthController::class, 'login', ['GET']);
$router->add('/login', \App\Controllers\AuthController::class, 'loginPost', ['POST']);
$router->add('/register', \App\Controllers\AuthController::class, 'register', ['GET']);
$router->add('/register', \App\Controllers\AuthController::class, 'registerPost', ['POST']);
$router->add('/logout', \App\Controllers\AuthController::class, 'logout', ['GET']);

// Routes pour les trajets (avec protection)
$router->add('/trajets/create', \App\Controllers\TrajetController::class, 'create');
$router->add('/trajets/store', \App\Controllers\TrajetController::class, 'store', ['POST']);
$router->add('/trajets/contact/{id}', \App\Controllers\TrajetController::class, 'contact');
$router->add('/trajets/send-message/{id}', \App\Controllers\TrajetController::class, 'sendMessage', ['POST']);
$router->add('/trajets/edit/{id}', \App\Controllers\TrajetController::class, 'edit');
$router->add('/trajets/update/{id}', \App\Controllers\TrajetController::class, 'update', ['POST']);
$router->add('/trajets/delete/{id}', \App\Controllers\TrajetController::class, 'destroy', ['POST']);
$router->add('/mes-trajets', \App\Controllers\TrajetController::class, 'myTrajets');

// Routes pour l'admin
$router->add('/admin/users', \App\Controllers\Admin\UserController::class, 'index');
$router->add('/admin/users/create', \App\Controllers\Admin\UserController::class, 'create');
$router->add('/admin/users/store', \App\Controllers\Admin\UserController::class, 'store', ['POST']);
$router->add('/admin/users/edit/{id}', \App\Controllers\Admin\UserController::class, 'edit');
$router->add('/admin/users/update/{id}', \App\Controllers\Admin\UserController::class, 'update', ['POST']);
$router->add('/admin/users/delete/{id}', \App\Controllers\Admin\UserController::class, 'destroy', ['POST']);

$router->add('/admin/agences', \App\Controllers\Admin\AgenceController::class, 'index');
$router->add('/admin/agences/create', \App\Controllers\Admin\AgenceController::class, 'create');
$router->add('/admin/agences/store', \App\Controllers\Admin\AgenceController::class, 'store', ['POST']);
$router->add('/admin/agences/edit/{id}', \App\Controllers\Admin\AgenceController::class, 'edit');
$router->add('/admin/agences/update/{id}', \App\Controllers\Admin\AgenceController::class, 'update', ['POST']);
$router->add('/admin/agences/delete/{id}', \App\Controllers\Admin\AgenceController::class, 'destroy', ['POST']);

$router->add('/admin/trajets', \App\Controllers\Admin\TrajetController::class, 'index');
$router->add('/admin/trajets/delete/{id}', \App\Controllers\Admin\TrajetController::class, 'destroy', ['POST']);

// Routes d'erreur
$router->add('/404', \App\Controllers\ErrorController::class, 'notFound');
$router->add('/403', \App\Controllers\ErrorController::class, 'forbidden');


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
    (new \App\Controllers\ErrorController())->notFound();
    exit;
}
