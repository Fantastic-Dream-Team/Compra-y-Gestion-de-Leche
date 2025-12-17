DELIMITER $$

CREATE TRIGGER trig_generar_codigo_productor
BEFORE INSERT ON usuarios_productor
FOR EACH ROW
BEGIN
    DECLARE random_3_cifras VARCHAR(3);
    DECLARE timestamp_part VARCHAR(12);
    DECLARE random_hexa_6 VARCHAR(6);
    DECLARE attempt INT DEFAULT 0;
    DECLARE max_attempts INT DEFAULT 5;
    DECLARE codigo_generado VARCHAR(25);
    DECLARE codigo_existe INT DEFAULT 1;
    
    IF NEW.codigo_productor IS NULL THEN
        WHILE attempt < max_attempts AND codigo_existe = 1 DO
            SET attempt = attempt + 1;
            
            -- Random 3 cifras (100-999)
            SET random_3_cifras = LPAD(FLOOR(100 + (RAND() * 900)), 3, '0');
            
            -- Timestamp (YYMMDDHHMMSS)
            SET timestamp_part = DATE_FORMAT(NOW(), '%y%m%d%H%i%s');
            
            -- Hexadecimal aleatorio de 6 caracteres
            SET random_hexa_6 = SUBSTRING(MD5(RAND()), 1, 6);
            
            -- Combinar en formato final
            SET codigo_generado = UPPER(CONCAT(random_3_cifras, '-', timestamp_part, '-', random_hexa_6));
            
            -- Verificar si el código ya existe
            SELECT COUNT(*) INTO codigo_existe 
            FROM usuarios_productor 
            WHERE codigo_productor = codigo_generado;
        END WHILE;
        
        -- Fallback seguro si hay colisión
        IF codigo_existe = 1 THEN
            SET codigo_generado = UPPER(CONCAT(
                LPAD(FLOOR(100 + (RAND() * 900)), 3, '0'), '-',
                DATE_FORMAT(NOW(), '%y%m%d%H%i%s'), '-',
                SUBSTRING(REPLACE(UUID(), '-', ''), 1, 6)
            ));
        END IF;
        
        SET NEW.codigo_productor = codigo_generado;
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trig_notificar_entrega_registrada
AFTER INSERT ON entregas
FOR EACH ROW
BEGIN
    DECLARE v_tipo_notif_id INT;
    
    -- Obtener id del tipo de notificación
    SELECT id INTO v_tipo_notif_id 
    FROM tipos_notificaciones 
    WHERE codigo = 'ENTREGA_REGISTRADA';
    
    -- Insertar notificación CON referencia a la entrega
    INSERT INTO notificaciones (
        id_usuario_productor,
        id_tipo_notificacion,
        id_entrega,
        mensaje,
        datos_contexto
    ) VALUES (
        NEW.id_usuario_productor,
        v_tipo_notif_id,
        NEW.id,  -- ← Aquí la referencia directa
        CONCAT('Tu entrega de ', NEW.litros, 'L el ', DATE_FORMAT(NEW.fecha, '%d/%m/%Y'), ' ha sido registrada exitosamente.'),
        JSON_OBJECT(
            'litros', NEW.litros,
            'fecha', NEW.fecha,
            'calidad', NEW.calidad,
            'entrega_id', NEW.id
        )
    );
END$$

DELIMITER ;