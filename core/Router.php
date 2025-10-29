<?php

namespace Core;

class Router
{
  private $routes = [];

  public function add(string $path, string $controller, string $method): void
  {
    $this->routes[$path] = [
      'controller' => $controller,
      'method' => $method,
      'path' => $path  // Stocke le chemin original pour la génération d'URLs
    ];
  }

  public function match(string $url): array
  {
    foreach ($this->routes as $path => $route) {
      // Convertit /agences/{id} en une regex comme #^/agences/(\d+)$#
      $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^\/]+)', $path);
      $regex = "@^" . $pattern . "$@";

      if (preg_match($regex, $url, $matches)) {
        // Filtre les paramètres nommés (ex: "id" => "5")
        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        return [
          'controller' => $route['controller'],
          'method' => $route['method'],
          'params' => array_values($params)  // Convertit en tableau indexé [0 => "5"]
        ];
      }
    }
    throw new \Exception("Route non trouvée: " . $url);
  }
}
