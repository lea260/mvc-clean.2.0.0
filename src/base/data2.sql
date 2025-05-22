INSERT INTO auto (patente, marca, modelo, estado)
VALUES 
('ABC123', 'Toyota', 'Corolla', 'disponible'),
('DEF456', 'Honda', 'Civic', 'reservado'),
('GHI789', 'Ford', 'Focus', 'vendido'),
('JKL321', 'Chevrolet', 'Onix', 'disponible'),
('MNO654', 'Volkswagen', 'Gol', 'disponible');

INSERT INTO usuario (nombre, correo_electronico)
VALUES 
('Juan Pérez', 'juan.perez@example.com'),        -- id = 1
('María López', 'maria.lopez@example.com'),      -- id = 2
('Carlos Díaz', 'carlos.diaz@example.com'),      -- id = 3
('Ana Torres', 'ana.torres@example.com');        -- id = 4

INSERT INTO reserva (id_usuario, id_auto)
VALUES 
(1, 2);

INSERT INTO venta (id_auto, id_vendedor)
VALUES 
(3, 3);
