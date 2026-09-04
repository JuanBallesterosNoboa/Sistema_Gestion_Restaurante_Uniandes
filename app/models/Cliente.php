<?php
require_once __DIR__ . '/../../config/database.php';

class Cliente {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function all(): array {
        return $this->db->query("SELECT * FROM clientes ORDER BY id DESC")->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $sql = "INSERT INTO clientes (cedula, nombres, apellidos, telefono, correo)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['cedula'], $data['nombres'], $data['apellidos'],
            $data['telefono'], $data['correo']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $sql = "UPDATE clientes SET cedula = ?, nombres = ?, apellidos = ?,
                telefono = ?, correo = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['cedula'], $data['nombres'], $data['apellidos'],
            $data['telefono'], $data['correo'], $id
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
    }
}
