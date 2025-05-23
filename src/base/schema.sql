CREATE DATABASE concesionaria;
USE concesionaria;

CREATE TABLE auto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patente VARCHAR(6) NOT NULL UNIQUE,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    estado ENUM('disponible', 'reservado', 'vendido') NOT NULL DEFAULT 'disponible',
    version INT NOT NULL DEFAULT 0
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_auto INT NOT NULL,
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_auto) REFERENCES auto(id),
    UNIQUE (id_auto) -- evita reservas múltiples del mismo auto
);

CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_auto INT NOT NULL,
    id_vendedor INT NOT NULL,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_auto) REFERENCES auto(id),
    FOREIGN KEY (id_vendedor) REFERENCES usuario(id)
);

