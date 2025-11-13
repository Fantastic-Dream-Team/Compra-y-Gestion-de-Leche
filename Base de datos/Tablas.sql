CREATE DATABASE donjoaquin;
USE donjoaquin;

CREATE TABLE productores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    finca VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,  
    ubicacion VARCHAR(255) NOT NULL,
    especialidad VARCHAR(255) NOT NULL,
    produccion VARCHAR(50) NOT NULL,  
    salud_animal VARCHAR(100) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE entregas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_productor INT NOT NULL,
    litros DECIMAL(10,2) NOT NULL,
    calidad VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    FOREIGN KEY (id_usuario_productor) REFERENCES usuarios_productor(id) ON DELETE CASCADE
);


CREATE TABLE usuarios_productor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_productor INT NOT NULL,
    nombre_usuario VARCHAR(35) NOT NULL UNIQUE,
    contrasenia VARCHAR(255) NOT NULL, -- Aumentado para almacenar hash seguro
    codigo_productor VARCHAR(30) UNIQUE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_productor) REFERENCES productores(id) ON DELETE CASCADE
);

    
    
