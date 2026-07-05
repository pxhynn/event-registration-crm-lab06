<?php
class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $handler): void
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    public function dispatch(string $method, string $uri, array $container): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        // Kiểm tra Route 404
        if (!isset($this->routes[$method][$path])) {
            // Check xem path có tồn tại dưới method khác không để ném 405
            foreach ($this->routes as $m => $paths) {
                if (isset($paths[$path])) {
                    http_response_code(405);
                    render('errors/404', ['title' => '405 Method Not Allowed', 'message' => 'Phương thức HTTP này không được cho phép đối với route hiện tại.']);
                    exit;
                }
            }
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found', 'message' => 'Trang bạn tìm kiếm không tồn tại trên hệ thống.']);
            exit;
        }

        [$class, $action] = $this->routes[$method][$path];
        if (isset($container[$class])) {
            $controllerInstance = $container[$class];
            $controllerInstance->$action();
        } else {
            throw new Exception("Class {$class} không tồn tại trong Service Container.");
        }
    }
}