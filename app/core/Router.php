<?php
class Router {
    public function dispatch(): void {
        $controllerName = $_GET['controller'] ?? 'cliente';
        $action = $_GET['action'] ?? 'index';

        $allowed = [
            'cliente' => 'ClienteController',
            'plato' => 'PlatoController',
            'mesa' => 'MesaController',
            'pedido' => 'PedidoController',
            'reporte' => 'ReporteController'
        ];

        if (!isset($allowed[$controllerName])) {
            http_response_code(404);
            exit('Controlador no encontrado.');
        }

        $file = __DIR__ . '/../controllers/' . $allowed[$controllerName] . '.php';
        require_once $file;
        $className = $allowed[$controllerName];
        $controller = new $className();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            exit('Acción no encontrada.');
        }

        $controller->$action();
    }
}
