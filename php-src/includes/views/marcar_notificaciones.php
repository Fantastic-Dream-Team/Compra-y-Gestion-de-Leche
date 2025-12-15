<?php
// marcar_notificacion.php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Compra-y-Gestion-de-Leche/php-src/includes/conexion.php';

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$response = ['success' => false, 'message' => 'Acción no válida'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $usuario_id = $_SESSION['usuario_id'];

    try {
        switch ($action) {
            case 'marcar_leida':
                if (isset($_POST['id'])) {
                    $notificacion_id = intval($_POST['id']);
                    
                    // Verificar que la notificación pertenece al usuario
                    $sql = "UPDATE notificaciones 
                            SET leida = TRUE, fecha_leida = NOW() 
                            WHERE id = ? AND id_usuario_productor = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $notificacion_id, $usuario_id);
                    
                    if ($stmt->execute()) {
                        $response = ['success' => true, 'message' => 'Notificación marcada como leída'];
                    }
                    $stmt->close();
                }
                break;
                
            case 'marcar_no_leida':
                if (isset($_POST['id'])) {
                    $notificacion_id = intval($_POST['id']);
                    
                    $sql = "UPDATE notificaciones 
                            SET leida = FALSE, fecha_leida = NULL 
                            WHERE id = ? AND id_usuario_productor = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $notificacion_id, $usuario_id);
                    
                    if ($stmt->execute()) {
                        $response = ['success' => true, 'message' => 'Notificación marcada como no leída'];
                    }
                    $stmt->close();
                }
                break;
                
            case 'marcar_todas_leidas':
                $sql = "UPDATE notificaciones 
                        SET leida = TRUE, fecha_leida = NOW() 
                        WHERE id_usuario_productor = ? AND leida = FALSE";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                
                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Todas las notificaciones marcadas como leídas'];
                }
                $stmt->close();
                break;
                
            case 'eliminar_leidas':
                $sql = "DELETE FROM notificaciones 
                        WHERE id_usuario_productor = ? AND leida = TRUE";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                
                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Notificaciones leídas eliminadas'];
                }
                $stmt->close();
                break;
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

$conn->close();
echo json_encode($response);
?>