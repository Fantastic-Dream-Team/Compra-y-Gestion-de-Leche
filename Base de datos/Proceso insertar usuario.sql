CREATE PROCEDURE sp_insertar_usuario_productor(
    IN p_id_productor INT,
    IN p_nombre_usuario VARCHAR(35),
    IN p_contrasenia_plana VARCHAR(255)
)

BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Verificar que el productor existe
    IF NOT EXISTS (SELECT 1 FROM productores WHERE id = p_id_productor) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El productor no existe';
    END IF;
    
    -- Verificar que el nombre de usuario no existe
    IF EXISTS (SELECT 1 FROM usuarios_productor WHERE nombre_usuario = p_nombre_usuario) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El nombre de usuario ya existe';
    END IF;
    
    -- Insertar usuario (el trigger generará el código automáticamente)
    INSERT INTO usuarios_productor (
        id_productor, 
        nombre_usuario, 
        contrasenia
    ) VALUES (
        p_id_productor,
        p_nombre_usuario,
        SHA2(CONCAT(p_contrasenia_plana, 'lacteos_salt'), 256)
    );
END
