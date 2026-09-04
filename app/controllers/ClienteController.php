<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController extends Controller {
    public function index(): void {
        $clientes = (new Cliente())->all();
        $this->view('clientes/index', compact('clientes'));
    }

    public function crear(): void {
        $this->view('clientes/form');
    }

    public function guardar(): void {
        $data = $this->getData();
        if (!$data['cedula'] || !$data['nombres'] || !$data['apellidos']) {
            exit('Complete los campos obligatorios.');
        }

        (new Cliente())->create($data);
        $this->redirect('index.php?controller=cliente');
    }

    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $cliente = (new Cliente())->find($id);
        if (!$cliente) exit('Cliente no encontrado.');
        $this->view('clientes/form', compact('cliente'));
    }

    public function actualizar(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = $this->getData();
        if ($id <= 0 || !$data['cedula'] || !$data['nombres'] || !$data['apellidos']) {
            exit('Complete los campos obligatorios.');
        }

        (new Cliente())->update($id, $data);
        $this->redirect('index.php?controller=cliente');
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            (new Cliente())->delete($id);
            $this->redirect('index.php?controller=cliente');
        } catch (PDOException $e) {
            $mensaje = urlencode('No se puede eliminar el cliente porque tiene pedidos.');
            $this->redirect("index.php?controller=cliente&error=$mensaje");
        }
    }

    private function getData(): array {
        return [
            'cedula' => trim($_POST['cedula'] ?? ''),
            'nombres' => trim($_POST['nombres'] ?? ''),
            'apellidos' => trim($_POST['apellidos'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'correo' => trim($_POST['correo'] ?? '')
        ];
    }
}
