CREATE DATABASE concesionaria;
USE concesionaria;

CREATE TABLE cars (
    patente VARCHAR(6) PRIMARY KEY,
    modelo VARCHAR(255) NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE,
    reservado BOOLEAN NOT NULL DEFAULT FALSE,
    version INT NOT NULL DEFAULT 0
);

