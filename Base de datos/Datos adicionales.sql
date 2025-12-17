-- Nuevas entregas actualizadas (diciembre 2025)
INSERT INTO entregas (id_usuario_productor, litros, calidad, fecha) VALUES
-- Roberto Mendoza (usuario 1) - Diciembre 2025
(1, 148.75, 'Excelente', '2025-12-10'),  -- 5 días atrás
(1, 152.30, 'Óptima', '2025-12-08'),     -- 7 días atrás
(1, 149.50, 'Buena', '2025-12-05'),      -- 10 días atrás
(1, 155.25, 'Excelente', '2025-11-28'),  -- 17 días atrás
(1, 147.80, 'Óptima', '2025-11-20'),     -- 25 días atrás

-- Carmen Silva (usuario 2) - Diciembre 2025
(2, 201.50, 'Óptima', '2025-12-11'),     -- 4 días atrás
(2, 198.75, 'Excelente', '2025-12-09'),  -- 6 días atrás
(2, 203.25, 'Buena', '2025-12-04'),      -- 11 días atrás
(2, 196.50, 'Óptima', '2025-11-26'),     -- 19 días atrás
(2, 205.00, 'Excelente', '2025-11-18'),  -- 27 días atrás

-- José Ramírez (usuario 3) - Diciembre 2025
(3, 81.25, 'Buena', '2025-12-12'),       -- 3 días atrás
(3, 83.50, 'Excelente', '2025-12-07'),   -- 8 días atrás
(3, 79.75, 'Regular', '2025-12-01'),     -- 14 días atrás (justo 14 días)
(3, 85.25, 'Óptima', '2025-11-24'),      -- 21 días atrás
(3, 80.50, 'Buena', '2025-11-16'),       -- 29 días atrás (casi 30)

-- Luisa Torres (usuario 4) - Diciembre 2025  
(4, 120.75, 'Óptima', '2025-12-13'),     -- 2 días atrás
(4, 118.50, 'Excelente', '2025-12-06'),  -- 9 días atrás
(4, 122.25, 'Buena', '2025-11-30'),      -- 15 días atrás (justo 15)
(4, 119.80, 'Óptima', '2025-11-22'),     -- 23 días atrás
(4, 124.00, 'Excelente', '2025-11-14'),  -- 31 días atrás (>30)

-- Miguel Castro (usuario 5) - Diciembre 2025
(5, 179.25, 'Excelente', '2025-12-14'),  -- 1 día atrás (ayer)
(5, 181.50, 'Óptima', '2025-12-03'),     -- 12 días atrás
(5, 177.75, 'Buena', '2025-11-25'),      -- 20 días atrás
(5, 183.00, 'Excelente', '2025-11-17'),  -- 28 días atrás
(5, 178.25, 'Óptima', '2025-11-09');     -- 36 días atrás (>30)

-- Insertar tipos de notificaciones básicas
INSERT INTO tipos_notificaciones (codigo, titulo, descripcion, prioridad) VALUES
-- Entregas
('ENTREGA_REGISTRADA', 'Entrega Registrada', 'Tu entrega de {litros}L el {fecha} ha sido registrada exitosamente.', 'BAJA'),
('ENTREGA_MODIFICADA', 'Entrega Modificada', 'Tu entrega del {fecha} ha sido actualizada.', 'MEDIA'),
('ENTREGA_ELIMINADA', 'Entrega Eliminada', 'Tu entrega del {fecha} ha sido eliminada del sistema.', 'ALTA'),

-- Pagos
('PAGO_PENDIENTE', 'Pago Pendiente', 'Tienes un pago pendiente de ${monto} por tu entrega del {fecha}.', 'ALTA'),
('PAGO_PROCESANDO', 'Pago en Proceso', 'Tu pago de ${monto} por la entrega del {fecha} está siendo procesado.', 'MEDIA'),
('PAGO_COMPLETADO', 'Pago Completado', 'Tu pago de ${monto} por la entrega del {fecha} ha sido completado.', 'BAJA'),
('PAGO_RECHAZADO', 'Pago Rechazado', 'Tu pago por la entrega del {fecha} fue rechazado. Razón: {razon}', 'ALTA'),

-- Inactividad
('INACTIVIDAD_7DIAS', 'Recordatorio de Entrega', 'No has registrado entregas en los últimos 7 días.', 'MEDIA'),
('INACTIVIDAD_15DIAS', 'Alerta de Inactividad', 'No has registrado entregas en los últimos 15 días.', 'ALTA'),
('INACTIVIDAD_30DIAS', 'Inactividad Prolongada', 'No has registrado entregas en los últimos 30 días. Contáctanos si necesitas ayuda.', 'ALTA'),

-- Calidad y Producción
('CALIDAD_BAJA', 'Alerta de Calidad', 'Tu entrega del {fecha} tuvo calidad "{calidad}". Considera revisar procesos.', 'MEDIA'),
('CALIDAD_EXCELENTE', '¡Excelente Trabajo!', 'Tu entrega del {fecha} tuvo calidad "Excelente". ¡Sigue así!', 'BAJA'),
('PRODUCCION_BAJA', 'Producción Disminuida', 'Tu producción ha disminuido un {porcentaje}% respecto al mes anterior.', 'MEDIA'),
('PRODUCCION_ALTA', 'Aumento de Producción', '¡Felicitaciones! Tu producción aumentó un {porcentaje}% este mes.', 'BAJA'),

-- Sistema y Comunicación
('NUEVO_MENSAJE', 'Nuevo Mensaje', 'Tienes un nuevo mensaje del administrador: "{asunto}".', 'ALTA'),
('SISTEMA_ACTUALIZACION', 'Actualización del Sistema', 'El sistema ha sido actualizado. Nuevas funciones disponibles.', 'MEDIA'),
('RECORDATORIO_CUMPLEANOS', '¡Feliz Cumpleaños!', '¡El equipo de Don Joaquín te desea un feliz cumpleaños!', 'BAJA'),
('PROMOCION_ESPECIAL', 'Promoción Especial', 'Promoción especial para productores: {detalle_promocion}.', 'MEDIA');

-- 1. Notificaciones de ejemplo basadas en las entregas existentes
-- Notificar que se registraron sus entregas (simulando historial)
INSERT INTO notificaciones (id_usuario_productor, id_tipo_notificacion, id_entrega, mensaje, datos_contexto)
SELECT 
    e.id_usuario_productor,
    tn.id,
    e.id,
    CONCAT('Entrega registrada: ', e.litros, 'L el ', DATE_FORMAT(e.fecha, '%d/%m/%Y'), '. Calidad: ', e.calidad),
    JSON_OBJECT(
        'litros', e.litros,
        'fecha', e.fecha,
        'calidad', e.calidad,
        'entrega_id', e.id
    )
FROM entregas e
CROSS JOIN (SELECT id FROM tipos_notificaciones WHERE codigo = 'ENTREGA_REGISTRADA') tn
WHERE e.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);

-- 2. Simular pagos pendientes para entregas recientes (CORREGIDO - sin prioridad)
INSERT INTO notificaciones (id_usuario_productor, id_tipo_notificacion, id_entrega, mensaje, datos_contexto)
SELECT 
    e.id_usuario_productor,
    tn.id,
    e.id,
    CONCAT('Pago pendiente: $', ROUND(e.litros * 2.5, 2), ' por entrega del ', DATE_FORMAT(e.fecha, '%d/%m/%Y')),
    JSON_OBJECT(
        'monto', ROUND(e.litros * 2.5, 2),
        'fecha', e.fecha,
        'litros', e.litros,
        'tipo_pago', 'POR_ENTREGA',
        'prioridad', 'ALTA'
    )
FROM entregas e
CROSS JOIN (SELECT id FROM tipos_notificaciones WHERE codigo = 'PAGO_PENDIENTE') tn
WHERE e.fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
LIMIT 3;

-- 3. Notificación de inactividad para algunos productores (ejemplo)
INSERT INTO notificaciones (id_usuario_productor, id_tipo_notificacion, mensaje, datos_contexto)
SELECT 
    up.id,
    tn.id,
    'No has registrado entregas en los últimos 15 días. Recuerda que puedes registrar tus entregas diarias en el sistema.',
    JSON_OBJECT(
        'ultima_entrega', DATE_SUB(CURDATE(), INTERVAL 16 DAY),
        'dias_inactivo', 16,
        'tipo_alerta', 'INACTIVIDAD_MEDIA'
    )
FROM usuarios_productor up
CROSS JOIN (SELECT id FROM tipos_notificaciones WHERE codigo = 'INACTIVIDAD_15DIAS') tn
WHERE up.id IN (2, 4)
AND NOT EXISTS (
    SELECT 1 FROM entregas e 
    WHERE e.id_usuario_productor = up.id 
    AND e.fecha >= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
);

-- 4. Notificaciones de calidad excelente
INSERT INTO notificaciones (id_usuario_productor, id_tipo_notificacion, id_entrega, mensaje, datos_contexto)
SELECT 
    e.id_usuario_productor,
    tn.id,
    e.id,
    CONCAT('¡Excelente trabajo! Tu entrega del ', DATE_FORMAT(e.fecha, '%d/%m/%Y'), ' tuvo calidad "', e.calidad, '".'),
    JSON_OBJECT(
        'fecha', e.fecha,
        'calidad', e.calidad,
        'reconocimiento', 'CALIDAD_EXCELENTE'
    )
FROM entregas e
CROSS JOIN (SELECT id FROM tipos_notificaciones WHERE codigo = 'CALIDAD_EXCELENTE') tn
WHERE e.calidad IN ('Excelente', 'Óptima')
AND e.fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
LIMIT 2;

-- 5. Notificación general del sistema
INSERT INTO notificaciones (id_usuario_productor, id_tipo_notificacion, mensaje)
SELECT 
    up.id,
    tn.id,
    'Bienvenido al sistema de notificaciones. Aquí recibirás actualizaciones sobre tus entregas, pagos y recordatorios importantes.'
FROM usuarios_productor up
CROSS JOIN (SELECT id FROM tipos_notificaciones WHERE codigo = 'SISTEMA_ACTUALIZACION') tn;