INSERT INTO cars (patente, modelo, disponible, reservado, version) VALUES
('ABC123', 'Sedan', TRUE, FALSE, 0),
('DEF456', 'Hatchback', TRUE, FALSE, 0),
('GHI789', 'SUV', FALSE, TRUE, 1),
('JKL012', 'Deportivo', TRUE, FALSE, 0),
('MNO345', 'Familiar', FALSE, FALSE, 0);

INSERT INTO usuario (nombre, correo_electronico)
VALUES 
('Juan Pérez', 'juan.perez@example.com'),
('María López', 'maria.lopez@example.com'),
('Carlos Díaz', 'carlos.diaz@example.com');

INSERT INTO reserva (id_usuario, id_auto)
VALUES 
(1, 2);

INSERT INTO venta (id_auto, id_vendedor)
VALUES 
(3, 3);
