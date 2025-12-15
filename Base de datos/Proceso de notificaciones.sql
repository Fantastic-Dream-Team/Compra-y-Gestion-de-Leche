DELIMITER $$

CREATE PROCEDURE sp_verificar_inactividad_productores()
BEGIN
    DECLARE v_usuario_id INT;
    DECLARE v_ultima_entrega DATE;
    DECLARE v_dias_inactivo INT;
    DECLARE done INT DEFAULT FALSE;
    
    DECLARE cur_usuarios CURSOR FOR
        SELECT up.id, 
               MAX(e.fecha) as ultima_entrega
        FROM usuarios_productor up
        LEFT JOIN entregas e ON up.id = e.id_usuario_productor
        GROUP BY up.id;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur_usuarios;
    
    read_loop: LOOP
        FETCH cur_usuarios INTO v_usuario_id, v_ultima_entrega;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Calcular días de inactividad
        IF v_ultima_entrega IS NULL THEN
            SET v_dias_inactivo = 999; -- Nunca ha registrado entrega
        ELSE
            SET v_dias_inactivo = DATEDIFF(CURDATE(), v_ultima_entrega);
        END IF;
        
        -- Crear notificaciones según días de inactividad (SIEMPRE)
        IF v_dias_inactivo = 7 THEN
            CALL sp_crear_notificacion(
                v_usuario_id, 
                'INACTIVIDAD_7DIAS',
                JSON_OBJECT('dias', 7, 'ultima_entrega', v_ultima_entrega)
            );
        ELSEIF v_dias_inactivo = 15 THEN
            CALL sp_crear_notificacion(
                v_usuario_id, 
                'INACTIVIDAD_15DIAS',
                JSON_OBJECT('dias', 15, 'ultima_entrega', v_ultima_entrega)
            );
        ELSEIF v_dias_inactivo >= 30 THEN
            CALL sp_crear_notificacion(
                v_usuario_id, 
                'INACTIVIDAD_30DIAS',
                JSON_OBJECT('dias', v_dias_inactivo, 'ultima_entrega', v_ultima_entrega)
            );
        END IF;
    END LOOP;
    
    CLOSE cur_usuarios;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_crear_notificacion(
    IN p_id_usuario_productor INT,
    IN p_codigo_tipo VARCHAR(50),
    IN p_datos_contexto JSON
)
BEGIN
    DECLARE v_tipo_notif_id INT;
    DECLARE v_descripcion TEXT;
    DECLARE v_mensaje TEXT;
    
    -- Obtener información del tipo de notificación
    SELECT id, descripcion 
    INTO v_tipo_notif_id, v_descripcion
    FROM tipos_notificaciones 
    WHERE codigo = p_codigo_tipo;
    
    -- Crear mensaje personalizado (SIEMPRE se envía)
    SET v_mensaje = v_descripcion;
    
    -- Reemplazar placeholders si hay datos de contexto
    IF p_datos_contexto IS NOT NULL THEN
        SET v_mensaje = REPLACE(v_mensaje, '{fecha}', COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_datos_contexto, '$.fecha')), ''));
        SET v_mensaje = REPLACE(v_mensaje, '{litros}', COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_datos_contexto, '$.litros')), ''));
        SET v_mensaje = REPLACE(v_mensaje, '{monto}', COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_datos_contexto, '$.monto')), ''));
        SET v_mensaje = REPLACE(v_mensaje, '{calidad}', COALESCE(JSON_UNQUOTE(JSON_EXTRACT(p_datos_contexto, '$.calidad')), ''));
    END IF;
    
    -- Insertar notificación (SIEMPRE)
    INSERT INTO notificaciones (
        id_usuario_productor,
        id_tipo_notificacion,
        mensaje,
        datos_contexto
    ) VALUES (
        p_id_usuario_productor,
        v_tipo_notif_id,
        v_mensaje,
        p_datos_contexto
    );
END$$

DELIMITER ;