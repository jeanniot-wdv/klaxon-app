<?php

namespace Core;

class Router
{
  private $routes = [];

  public function add(string $path, string $controller, string $method, array $httpMethods = ['GET']): void
  {
    if (!isset($this->routes[$path])) {
      $this->routes[$path] = [];
    }
    foreach ($httpMethods as $httpMethod) {
      $this->routes[$path][$httpMethod] = [
        'controller' => $controller,
        'method' => $method,
        'path' => $path
      ];
    }
  }

  public function match(string $url): array
  {
    $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    foreach ($this->routes as $path => $methods) {
      // Convertit /agences/{id} en une regex comme #^/agences/(\d+)$#
      $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^\/]+)', $path);
      $regex = "@^" . $pattern . "$@";

      if (preg_match($regex, $url, $matches)) {
        if (isset($methods[$requestMethod])) {
          $route = $methods[$requestMethod];
        // Filtre les paramètres nommés (ex: "id" => "5")
        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        return [
          'controller' => $route['controller'],
          'method' => $route['method'],
          'params' => array_values($params)  // Convertit en tableau indexé [0 => "5"]
        ];
      }
    }
    }
    throw new \Exception("Route non trouvée: " . $url);
  }
}
