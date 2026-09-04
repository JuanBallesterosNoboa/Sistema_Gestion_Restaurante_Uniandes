<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Plato.php';

class PlatoController extends Controller {
    public function index(): void {
        $platos = (new Plato())->all();
        $this->view('platos/index', compact('platos'));
    }

    public function crear(): void {
        $this->view('platos/form');
    }

    public function guardar(): void {
        $data = $this->getData();
        if (!$data['nombre'] || $data['precio'] <= 0) {
            exit('Complete correctamente los campos obligatorios.');
        }

        (new Plato())->create($data);
        $this->redirect('index.php?controller=plato');
    }

    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $plato = (new Plato())->find($id);
        if (!$plato) exit('Plato no encontrado.');
        $this->view('platos/form', compact('plato'));
    }

    public function actualizar(): void {
        $id = (int)($_POST['id'] ?? 0);
        $data = $this->getData();
        if ($id <= 0 || !$data['nombre'] || $data['precio'] <= 0) {
            exit('Complete correctamente los campos obligatorios.');
        }

        (new Plato())->update($id, $data);
        $this->redirect('index.php?controller=plato');
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            (new Plato())->delete($id);
            $this->redirect('index.php?controller=plato');
        } catch (PDOException $e) {
            $mensaje = urlencode('No se puede eliminar el plato porque tiene pedidos.');
            $this->redirect("index.php?controller=plato&error=$mensaje");
        }
    }

    private function getData(): array {
        return [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => (float)($_POST['precio'] ?? 0),
            'disponible' => isset($_POST['disponible']) ? 1 : 0
        ];
    }
}
