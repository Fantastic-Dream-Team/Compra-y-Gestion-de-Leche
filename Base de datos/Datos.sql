-- Productores --
INSERT INTO productores (nombre, finca, foto, ubicacion, especialidad, produccion, salud_animal) VALUES
('Roberto Mendoza García', 'Finca La Esperanza', 'roberto_mendoza.jpg', 'Valle del Cauca, Cartago', 'Queso Fresco Campesino', '150 litros/día', 'Excelente - Vacunación al día'),
('Carmen Silva Rodríguez', 'Finca Vista Hermosa', 'carmen_silva.jpg', 'Antioquia, San Pedro de los Milagros', 'Leche Entera Premium', '200 litros/día', 'Óptima - Control mensual'),
('José Antonio Ramírez López', 'Finca El Porvenir', 'jose_ramirez.jpg', 'Cundinamarca, Facatativá', 'Yogurt Natural Artesanal', '80 litros/día', 'Buena - Seguimiento veterinario'),
('Luisa Fernanda Torres Martínez', 'Finca La Holanda', 'luisa_torres.jpg', 'Boyacá, Sogamoso', 'Queso Doble Crema', '120 litros/día', 'Excelente - Certificado orgánico'),
('Miguel Ángel Castro Díaz', 'Finca San Isidro', 'miguel_castro.jpg', 'Nariño, Pasto', 'Leche Pasteurizada', '180 litros/día', 'Óptima - Inspección sanitaria');

-- Usuarios de productores --
CALL sp_insertar_usuario_productor(1, 'roberto_mendoza', 'roberto2024');
CALL sp_insertar_usuario_productor(2, 'carmen_silva', 'carmenSafe456');
CALL sp_insertar_usuario_productor(3, 'jose_ramirez', 'ramirezJ789');
CALL sp_insertar_usuario_productor(4, 'luisa_torres', 'luisaT!2024');
CALL sp_insertar_usuario_productor(5, 'miguel_castro', 'miguelC@123');

INSERT INTO entregas (id_usuario_productor, litros, calidad, fecha) VALUES
-- Entregas de Roberto Mendoza (Queso Fresco)
(1, 145.50, 'Excelente', '2024-10-01'),
(1, 152.75, 'Buena', '2024-10-03'),
(1, 148.25, 'Excelente', '2024-10-05'),
(1, 155.00, 'Óptima', '2024-10-07'),
(1, 149.80, 'Buena', '2024-10-09'),

-- Entregas de Carmen Silva (Leche Entera)
(2, 198.00, 'Óptima', '2024-10-02'),
(2, 203.50, 'Excelente', '2024-10-04'),
(2, 195.75, 'Buena', '2024-10-06'),
(2, 205.25, 'Óptima', '2024-10-08'),
(2, 200.50, 'Excelente', '2024-10-10'),

-- Entregas de José Ramírez (Yogurt)
(3, 78.25, 'Buena', '2024-10-01'),
(3, 82.50, 'Excelente', '2024-10-03'),
(3, 79.75, 'Regular', '2024-10-05'),
(3, 85.00, 'Óptima', '2024-10-07'),
(3, 80.25, 'Buena', '2024-10-09'),

-- Entregas de Luisa Torres (Queso Doble Crema)
(4, 118.00, 'Óptima', '2024-10-02'),
(4, 122.50, 'Excelente', '2024-10-04'),
(4, 115.75, 'Buena', '2024-10-06'),
(4, 125.80, 'Óptima', '2024-10-08'),
(4, 119.25, 'Excelente', '2024-10-10'),

-- Entregas de Miguel Castro (Leche Pasteurizada)
(5, 176.25, 'Excelente', '2024-10-01'),
(5, 182.50, 'Óptima', '2024-10-03'),
(5, 178.75, 'Buena', '2024-10-05'),
(5, 185.00, 'Excelente', '2024-10-07'),
(5, 180.25, 'Óptima', '2024-10-09');
