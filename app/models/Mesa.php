<?php
require_once __DIR__ . '/../../config/database.php';

class Mesa {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function all(): array {
        return $this->db->query("SELECT * FROM mesas ORDER BY numero")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM mesas WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $sql = "INSERT INTO mesas (numero, capacidad, estado) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['numero'], $data['capacidad'], $data['estado']]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $sql = "UPDATE mesas SET numero = ?, capacidad = ?, estado = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['numero'], $data['capacidad'], $data['estado'], $id]);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM mesas WHERE id = ?");
        $stmt->execute([$id]);
    }
}
