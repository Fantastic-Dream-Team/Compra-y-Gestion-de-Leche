<?php
// procesar_entrega.php - En la misma carpeta que dashboard.php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Incluir conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/Compra-y-Gestion-de-Leche/php-src/includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $litros = floatval($_POST['litros']);
    $calidad = $_POST['calidad'];
    $fecha = $_POST['fecha'];
    $observaciones = $_POST['observaciones'] ?? '';
    
    // Validar que el usuario_id de la sesión coincida
    if ($usuario_id != $_SESSION['usuario_id']) {
        header('Location: dashboard.php?error=acceso_denegado');
        exit();
    }
    
    // Validar datos
    if ($litros <= 0 || $litros > 1000) {
        header('Location: dashboard.php?error=litros_invalidos');
        exit();
    }
    
    if (!in_array($calidad, ['Excelente', 'Buena', 'Regular', 'Deficiente'])) {
        header('Location: dashboard.php?error=calidad_invalida');
        exit();
    }
    
    try {
        // Insertar la entrega en la base de datos
        $sql = "INSERT INTO entregas 
                (id_usuario_productor, litros, calidad, fecha, observaciones) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idsss", $usuario_id, $litros, $calidad, $fecha, $observaciones);
        
        if ($stmt->execute()) {
            // Éxito - redirigir al dashboard con mensaje de éxito
            header('Location: dashboard.php?success=entrega_registrada');
        } else {
            // Error en la inserción
            header('Location: dashboard.php?error=error_registro');
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        // Error en la base de datos
        error_log("Error al registrar entrega: " . $e->getMessage());
        header('Location: dashboard.php?error=error_bd');
    }
    
    $conn->close();
    
} else {
    // Si alguien intenta acceder directamente
    header('Location: dashboard.php');
    exit();
}
?>