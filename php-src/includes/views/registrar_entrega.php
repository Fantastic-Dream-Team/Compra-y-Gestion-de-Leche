<?php
// registrar_entrega.php

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Incluir conexión a la base de datos
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $litros = floatval($_POST['litros']);
    $grasa = floatval($_POST['grasa']);
    $proteina = floatval($_POST['proteina']);
    $fecha = $_POST['fecha'];
    $calidad = $_POST['calidad'];
    $observaciones = $_POST['observaciones'] ?? '';
    
    // Validar que el usuario_id de la sesión coincida
    if ($usuario_id != $_SESSION['usuario_id']) {
        // Redirigir con error
        header('Location: panel_productor.php?error=acceso_denegado');
        exit();
    }
    
    try {
        // Insertar la entrega en la base de datos
        $sql = "INSERT INTO entregas 
                (id_usuario_productor, litros, grasa, proteina, fecha, calidad, observaciones, fecha_creacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iddddss", $usuario_id, $litros, $grasa, $proteina, $fecha, $calidad, $observaciones);
        
        if ($stmt->execute()) {
            // Éxito - redirigir al panel con mensaje de éxito
            header('Location: panel_productor.php?success=entrega_registrada');
        } else {
            // Error en la inserción
            header('Location: panel_productor.php?error=error_registro');
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        // Error en la base de datos
        error_log("Error al registrar entrega: " . $e->getMessage());
        header('Location: panel_productor.php?error=error_bd');
    }
    
    $conn->close();
    
} else {
    // Si alguien intenta acceder directamente
    header('Location: panel_productor.php');
    exit();
}