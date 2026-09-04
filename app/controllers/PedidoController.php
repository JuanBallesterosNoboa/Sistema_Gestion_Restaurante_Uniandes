<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Plato.php';
require_once __DIR__ . '/../models/Mesa.php';

class PedidoController extends Controller {
    public function index(): void {
        $pedidos = (new Pedido())->all();
        $this->view('pedidos/index', compact('pedidos'));
    }

    public function crear(): void {
        $clientes = (new Cliente())->all();
        $platos = (new Plato())->all();
        $mesas = (new Mesa())->all();
        $this->view('pedidos/form', compact('clientes', 'platos', 'mesas'));
    }

    public function guardar(): void {
        $data = $this->getData();
        if ($data['cliente_id'] <= 0 || $data['plato_id'] <= 0 ||
            $data['mesa_id'] <= 0 || $data['cantidad'] <= 0) {
            exit('Complete los campos obligatorios.');
        }

        (new Pedido())->create($data);
        $this->redirect('index.php?controller=pedido');
    }

    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $pedido = (new Pedido())->find($id);
        if (!$pedido) exit('Pedido no encontrado.');

        $clientes = (new Cliente())->all();
        $platos = (new Plato())->all();
        $mesas = (new Mesa())->all();
        $this->view('pedidos/form', compact('pedido', 'clientes', 'platos', 'mesas'));
    }

    public function actualizar(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = $this->getData();
        if ($id <= 0 || $data['cliente_id'] <= 0 || $data['plato_id'] <= 0 ||
            $data['mesa_id'] <= 0 || $data['cantidad'] <= 0) {
            exit('Complete los campos obligatorios.');
        }

        (new Pedido())->update($id, $data);
        $this->redirect('index.php?controller=pedido');
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        (new Pedido())->delete($id);
        $this->redirect('index.php?controller=pedido');
    }

    private function getData(): array {
        return [
            'cliente_id' => (int)($_POST['cliente_id'] ?? 0),
            'plato_id' => (int)($_POST['plato_id'] ?? 0),
            'mesa_id' => (int)($_POST['mesa_id'] ?? 0),
            'cantidad' => (int)($_POST['cantidad'] ?? 0),
            'fecha' => str_replace('T', ' ', $_POST['fecha'] ?? date('Y-m-d H:i')),
            'estado' => trim($_POST['estado'] ?? 'Pendiente')
        ];
    }
}
