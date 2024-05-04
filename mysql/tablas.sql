
-- Esta tabla almacenará la información básica de los usuarios.
CREATE TABLE Usuarios (

    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    HashContraseña VARCHAR(255) NOT NULL

) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Para manejar a los instructores de manera independiente y permitir que una clase sea impartida por diferentes instructores en diferentes horarios.
CREATE TABLE Instructores (

    InstructorID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Esta tabla gestionará la información de las clases ofrecidas.
CREATE TABLE Clases (

    ClaseID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    InstructorID INT,
    FOREIGN KEY (InstructorID) REFERENCES Instructores(InstructorID)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Gestiona cuándo y dónde se ofrecen las clases.
CREATE TABLE HorariosClases (

    HorarioID INT AUTO_INCREMENT PRIMARY KEY,
    ClaseID INT,
    Fecha DATE NOT NULL,
    HoraInicio TIME NOT NULL,
    Duracion INT NOT NULL,
    Capacidad INT NOT NULL,
    FOREIGN KEY (ClaseID) REFERENCES Clases(ClaseID)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Registra qué usuario se ha inscrito en qué clase y en qué horario.
CREATE TABLE Inscripciones (

    InscripcionID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    HorarioID INT,
    FOREIGN KEY (UserID) REFERENCES Usuarios(UserID),
    FOREIGN KEY (HorarioID) REFERENCES HorariosClases(HorarioID)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;