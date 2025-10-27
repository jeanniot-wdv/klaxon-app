<?php
namespace Core;

// Classe simple de routage
class Router
{
    private $routes = []; // Tableau des routes

    public function add(string $path, string $controller, string $method): void
    {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }

    // Trouve la route correspondant à l'URL donnée
    public function match(string $url): array
    {
        foreach ($this->routes as $path => $route) {
            if ($path === $url) {
                return $route;
            }
        }
        throw new \Exception("Aucune route correspondante trouvée pour l'URL : " . $url);
    }
}
