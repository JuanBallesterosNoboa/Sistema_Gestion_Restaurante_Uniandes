<?php
require_once __DIR__ . '/../../config/database.php';

class Pedido {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function all(): array {
        $sql = "SELECT p.*, CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                       pl.nombre AS plato, m.numero AS mesa
                FROM pedidos p
                INNER JOIN clientes c ON c.id = p.cliente_id
                INNER JOIN platos pl ON pl.id = p.plato_id
                INNER JOIN mesas m ON m.id = p.mesa_id
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $precio = $this->getPrecio((int)$data['plato_id']);
        $total = $precio * (int)$data['cantidad'];

        $sql = "INSERT INTO pedidos
                (cliente_id, plato_id, mesa_id, cantidad, precio_unitario, total, fecha, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['cliente_id'], $data['plato_id'], $data['mesa_id'],
            $data['cantidad'], $precio, $total, $data['fecha'], $data['estado']
        ]);

        $this->updateMesa((int)$data['mesa_id']);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $anterior = $this->find($id);
        $precio = $this->getPrecio((int)$data['plato_id']);
        $total = $precio * (int)$data['cantidad'];

        $sql = "UPDATE pedidos SET cliente_id = ?, plato_id = ?, mesa_id = ?,
                cantidad = ?, precio_unitario = ?, total = ?, fecha = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['cliente_id'], $data['plato_id'], $data['mesa_id'],
            $data['cantidad'], $precio, $total, $data['fecha'], $data['estado'], $id
        ]);

        if ($anterior) $this->updateMesa((int)$anterior['mesa_id']);
        $this->updateMesa((int)$data['mesa_id']);
    }

    public function delete(int $id): void {
        $pedido = $this->find($id);
        $stmt = $this->db->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        if ($pedido) $this->updateMesa((int)$pedido['mesa_id']);
    }

    private function getPrecio(int $platoId): float {
        $stmt = $this->db->prepare("SELECT precio FROM platos WHERE id = ?");
        $stmt->execute([$platoId]);
        return (float)$stmt->fetchColumn();
    }

    private function updateMesa(int $mesaId): void {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM pedidos
            WHERE mesa_id = ? AND estado IN ('Pendiente', 'En preparación', 'Servido')");
        $stmt->execute([$mesaId]);
        $estado = $stmt->fetchColumn() > 0 ? 'Ocupada' : 'Disponible';
        $update = $this->db->prepare("UPDATE mesas SET estado = ? WHERE id = ?");
        $update->execute([$estado, $mesaId]);
    }
}
