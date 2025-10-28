-- Crear la base de datos
CREATE DATABASE GameStore;
GO

-- Usar la base de datos
USE GameStore;
GO

-- Tabla de Usuarios
CREATE TABLE Usuarios (
    id_usuario INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL CHECK (rol IN ('admin', 'vendedor', 'cliente'))
);
GO

-- Tabla de Juegos
CREATE TABLE Juegos (
    id_juego INT IDENTITY(1,1) PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    genero VARCHAR(50),
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    id_vendedor INT,
    FOREIGN KEY (id_vendedor) REFERENCES Usuarios(id_usuario)
);
GO

-- Tabla de Transacciones
CREATE TABLE Transacciones (
    id_transaccion INT IDENTITY(1,1) PRIMARY KEY,
    id_cliente INT,
    fecha DATETIME NOT NULL DEFAULT GETDATE(),
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario)
);
GO

-- Tabla de Detalle_Transaccion
CREATE TABLE Detalle_Transaccion (
    id_detalle INT IDENTITY(1,1) PRIMARY KEY,
    id_transaccion INT,
    id_juego INT,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_transaccion) REFERENCES Transacciones(id_transaccion),
    FOREIGN KEY (id_juego) REFERENCES Juegos(id_juego)
);
GO

-- Insertar un usuario administrador por defecto
INSERT INTO Usuarios (nombre, correo, contraseña, rol) VALUES ('Admin', 'admin@gamestore.com', '$2y$10$E.q2.b3j.C4V7G6E8F9H0I.Uv.wXyZ/A1B2C3D4E5F6G7H8I9J0', 'admin'); -- Contraseña: admin
GO
