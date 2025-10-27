<?php
namespace Core;

class Router
{
    private $routes = [];

    public function add(string $path, string $controller, string $method): void
    {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }

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
