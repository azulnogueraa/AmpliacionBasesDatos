-- Insertar datos en la tabla de Usuarios
INSERT INTO Usuarios (Nombre, Email, HashContraseña) VALUES
('Juan Perez', 'juan.perez@gmail.com', 'juanperez'),
('Ana Lopez', 'ana.lopez@gmail.com', 'analopez'),
('Carlos Ruiz', 'carlos.ruiz@gmail.com', 'carlosruiz'),
('Julian Fernandez', 'julian.fernandez@gmail.com', 'julianfernandez'),
('Marta Sanchez', 'marta.sanchez@gmail.com', 'martasanchez');

-- Insertar datos en la tabla de Instructores
INSERT INTO Instructores (Nombre) VALUES
('Marta Gimenez'),
('Luis Molina'),
('Sofia Castro'),
('Romina Garcia'),
('Clara Rodriguez');

-- Insertar datos en la tabla de Clases
INSERT INTO Clases (Nombre, Descripcion, InstructorID) VALUES
('Yoga', 'Clase de yoga enfocada a principiantes. Ideal para relajar mente y cuerpo.', 1),
('Crossfit', 'Clase de crossfit para aquellos que buscan un desafío mayor.', 2),
('Pilates', 'Clase avanzada de pilates, requiere experiencia previa.', 3),
('Body Pump', 'Entrenamiento para quemar calorias y tonificar tu cuerpo.', 4),
('Spinning', 'Entrenamiento con bicicletas de ultima generación.', 5);

-- Insertar datos en la tabla de HorariosClases
INSERT INTO HorariosClases (ClaseID, Fecha, HoraInicio, Duracion, Capacidad) VALUES
(1, '2024-05-01', '08:00:00', 60, 10),
(2, '2024-05-01', '10:00:00', 60, 10),
(3, '2024-05-01', '12:00:00', 90, 5),
(4, '2024-05-01', '15:00:00', 40, 10),
(5, '2024-05-01', '17:00:00', 60, 5),
(1, '2024-05-02', '08:00:00', 60, 10),
(2, '2024-05-02', '10:00:00', 60, 10),
(3, '2024-05-02', '12:00:00', 90, 5),
(4, '2024-05-02', '15:00:00', 40, 10),
(5, '2024-05-02', '17:00:00', 60, 5),
(1, '2024-05-03', '08:00:00', 60, 10),
(2, '2024-05-03', '10:00:00', 60, 10),
(3, '2024-05-03', '12:00:00', 90, 5),
(4, '2024-05-03', '15:00:00', 40, 10),
(5, '2024-05-03', '17:00:00', 60, 5),
(1, '2024-05-04', '08:00:00', 60, 10),
(2, '2024-05-04', '10:00:00', 60, 10),
(3, '2024-05-04', '12:00:00', 90, 5),
(4, '2024-05-04', '15:00:00', 40, 10),
(5, '2024-05-04', '17:00:00', 60, 5),
(1, '2024-05-05', '08:00:00', 60, 10),
(2, '2024-05-05', '10:00:00', 60, 10),
(3, '2024-05-05', '12:00:00', 90, 5),
(4, '2024-05-05', '15:00:00', 40, 10),
(5, '2024-05-05', '17:00:00', 60, 5);

-- Insertar datos en la tabla de Inscripciones
INSERT INTO Inscripciones (UserID, HorarioID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);
