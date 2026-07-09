<?php

namespace App\Core;

/**
 * Routeur de l'application.
 */
class Router
{
    /**
     * Tableau des routes.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Ajoute une route.
     *
     * @param string $url
     * @param callable|array $action
     *
     * @return void
     */
    public function get(string $url, callable|array $action): void
    {
        $this->routes['GET'][$url] = $action;
    }

    /**
     * Exécute la route demandée.
     *
     * @return void
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "Page non trouvée";
            return;
        }

        $action = $this->routes[$method][$uri];

        if (is_array($action)) {

            $controller = new $action[0];
            $method = $action[1];

            $controller->$method();

            return;
        }

        $action();
    }
}