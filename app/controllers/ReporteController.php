<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reporte.php';
require_once __DIR__ . '/../models/Cliente.php';

class ReporteController extends Controller {
    public function index(): void {
        $clienteId = (int)($_GET['cliente_id'] ?? 0);
        $clientes = (new Cliente())->all();
        $reporte = new Reporte();
        $pedidos = $reporte->pedidosPorCliente($clienteId);
        $resumen = $reporte->resumen($clienteId);
        $this->view('reportes/index', compact(
            'clientes', 'pedidos', 'resumen', 'clienteId'
        ));
    }
}
