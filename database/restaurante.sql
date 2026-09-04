CREATE DATABASE IF NOT EXISTS restaurante
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE restaurante;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(10) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(10) NULL,
    correo VARCHAR(100) NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE platos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    precio DECIMAL(10,2) NOT NULL,
    disponible TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL UNIQUE,
    capacidad INT NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Disponible',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    plato_id INT NOT NULL,
    mesa_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha DATETIME NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'Pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedido_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_pedido_plato FOREIGN KEY (plato_id) REFERENCES platos(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_pedido_mesa FOREIGN KEY (mesa_id) REFERENCES mesas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO clientes (cedula, nombres, apellidos, telefono, correo) VALUES
('0912345678', 'Carlos', 'Mendoza', '0991112233', 'carlos@email.com'),
('0923456789', 'María', 'Zambrano', '0982223344', 'maria@email.com');

INSERT INTO platos (nombre, descripcion, precio, disponible) VALUES
('Ceviche de camarón', 'Camarón, cebolla, tomate y limón', 8.50, 1),
('Arroz con pollo', 'Arroz con pollo y ensalada', 6.00, 1),
('Jugo natural', 'Jugo de fruta de temporada', 2.00, 1);

INSERT INTO mesas (numero, capacidad, estado) VALUES
(1, 4, 'Disponible'),
(2, 4, 'Ocupada'),
(3, 6, 'Disponible');

INSERT INTO pedidos
(cliente_id, plato_id, mesa_id, cantidad, precio_unitario, total, fecha, estado)
VALUES
(1, 1, 1, 2, 8.50, 17.00, NOW(), 'Pagado'),
(2, 2, 2, 1, 6.00, 6.00, NOW(), 'Pendiente');
