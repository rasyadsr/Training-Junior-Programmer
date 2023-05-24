<?php

namespace App\Core;

/**
 * @method get(string $path, mixed $arguments)
 * @method post(string $path, mixed $arguments)
 * @method get(string $path, mixed $arguments)
 */
class Route
{
    private array $routes = [];

    /**
     * @var $arguments[0] = HTTP METHOD
     * @var $arguments[1] = Handler
     */
    public function __call($httpMethod, $arguments): Route
    {
        $path    = $arguments[0];
        $handler = $arguments[1];

        array_push($this->routes, [
            'method'  => strtoupper($httpMethod),
            'path'    => $path,
            'handler' => $handler
        ]);

        return $this;
    }

    public function listen(): void
    {
        $path = $_SERVER['PATH_INFO'] ?? "/";
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match('#^' . $route['path'] . '$#', $path, $paraneters)) {
                $handler = $route['handler'];

                array_shift($paraneters);
                // berarti pake controller
                if (is_array($handler)) {
                    $controller = new $handler[0];
                    $function   = $handler[1];
                    call_user_func_array([$controller, $function], $paraneters);
                }

                // berarti callback function
                if (is_callable($handler)) {
                    $request = new \App\Core\Request();
                    $response = new \App\Core\Response();

                    call_user_func_array($handler, [$request, $response]);
                }

                return;
            }
        }

        $this->notFoundHandler();
    }

    public function middleware(mixed $middleware)
    {
    }

    public function notFoundHandler()
    {
        http_response_code(404);
        echo "404";
    }
}
