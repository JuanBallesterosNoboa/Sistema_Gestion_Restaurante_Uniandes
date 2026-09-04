<?php
require_once __DIR__ . '/../../config/database.php';

class Plato {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function all(): array {
        return $this->db->query("SELECT * FROM platos ORDER BY id DESC")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM platos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $sql = "INSERT INTO platos (nombre, descripcion, precio, disponible)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nombre'], $data['descripcion'],
            $data['precio'], $data['disponible']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $sql = "UPDATE platos SET nombre = ?, descripcion = ?, precio = ?,
                disponible = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nombre'], $data['descripcion'],
            $data['precio'], $data['disponible'], $id
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM platos WHERE id = ?");
        $stmt->execute([$id]);
    }
}
