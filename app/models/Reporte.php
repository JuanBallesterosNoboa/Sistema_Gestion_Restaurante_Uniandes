<?php
require_once __DIR__ . '/../../config/database.php';

class Reporte {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function pedidosPorCliente(int $clienteId = 0): array {
        $sql = "SELECT p.*, CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                       pl.nombre AS plato, m.numero AS mesa
                FROM pedidos p
                INNER JOIN clientes c ON c.id = p.cliente_id
                INNER JOIN platos pl ON pl.id = p.plato_id
                INNER JOIN mesas m ON m.id = p.mesa_id";

        if ($clienteId > 0) {
            $sql .= " WHERE p.cliente_id = ?";
        }

        $sql .= " ORDER BY c.apellidos, p.fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($clienteId > 0 ? [$clienteId] : []);
        return $stmt->fetchAll();
    }

    public function resumen(int $clienteId = 0): array {
        $sql = "SELECT c.cedula, CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                       COUNT(p.id) AS pedidos,
                       SUM(CASE WHEN p.estado <> 'Cancelado' THEN p.total ELSE 0 END) AS total
                FROM pedidos p
                INNER JOIN clientes c ON c.id = p.cliente_id";

        if ($clienteId > 0) {
            $sql .= " WHERE p.cliente_id = ?";
        }

        $sql .= " GROUP BY c.id, c.cedula, c.nombres, c.apellidos ORDER BY total DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($clienteId > 0 ? [$clienteId] : []);
        return $stmt->fetchAll();
    }
}
