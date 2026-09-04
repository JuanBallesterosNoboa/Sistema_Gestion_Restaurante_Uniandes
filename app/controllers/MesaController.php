<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Mesa.php';

class MesaController extends Controller {
    public function index(): void {
        $mesas = (new Mesa())->all();
        $this->view('mesas/index', compact('mesas'));
    }

    public function crear(): void {
        $this->view('mesas/form');
    }

    public function guardar(): void {
        $data = $this->getData();
        if ($data['numero'] <= 0 || $data['capacidad'] <= 0) {
            exit('Complete correctamente los campos obligatorios.');
        }

        (new Mesa())->create($data);
        $this->redirect('index.php?controller=mesa');
    }

    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $mesa = (new Mesa())->find($id);
        if (!$mesa) exit('Mesa no encontrada.');
        $this->view('mesas/form', compact('mesa'));
    }

    public function actualizar(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = $this->getData();
        if ($id <= 0 || $data['numero'] <= 0 || $data['capacidad'] <= 0) {
            exit('Complete correctamente los campos obligatorios.');
        }

        (new Mesa())->update($id, $data);
        $this->redirect('index.php?controller=mesa');
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            (new Mesa())->delete($id);
            $this->redirect('index.php?controller=mesa');
        } catch (PDOException $e) {
            $mensaje = urlencode('No se puede eliminar la mesa porque tiene pedidos.');
            $this->redirect("index.php?controller=mesa&error=$mensaje");
        }
    }

    private function getData(): array {
        return [
            'numero' => (int)($_POST['numero'] ?? 0),
            'capacidad' => (int)($_POST['capacidad'] ?? 0),
            'estado' => trim($_POST['estado'] ?? 'Disponible')
        ];
    }
}
