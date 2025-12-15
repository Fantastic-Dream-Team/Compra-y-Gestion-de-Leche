-- Tabla para tipos de notificaciones (catálogo)
CREATE TABLE tipos_notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,  -- Ej: 'ENTREGA_REGISTRADA', 'PAGO_PENDIENTE'
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,  -- Plantilla con placeholders
    prioridad ENUM('BAJA', 'MEDIA', 'ALTA') DEFAULT 'MEDIA',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para notificaciones individuales
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_productor INT NOT NULL,
    id_entrega INT NULL,
    id_tipo_notificacion INT NOT NULL,
    mensaje TEXT NOT NULL,  -- Mensaje personalizado
    datos_contexto JSON,  -- Datos adicionales en formato JSON
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_leida DATETIME NULL,
    FOREIGN KEY (id_usuario_productor) REFERENCES usuarios_productor(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_notificacion) REFERENCES tipos_notificaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (id_entrega) REFERENCES entregas(id) ON DELETE SET NULL
);

