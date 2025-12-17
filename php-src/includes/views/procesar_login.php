<?php
// procesar_login.php
session_start();

// Incluir conexión a la base de datos
require_once __DIR__ . '/../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $codigo_productor = trim($_POST['codigo'] ?? '');
    
    // Validar que todos los campos estén completos
    if (empty($username) || empty($password) || empty($codigo_productor)) {
        header('Location: login.php?error=vacios');
        exit();
    }
    
    try {
        // Consulta para verificar las credenciales
        // La contraseña en la BD se guarda con SHA256 y un salt
        $sql = "SELECT up.id, up.id_productor, up.nombre_usuario, up.codigo_productor,
                p.nombre AS productor_nombre, p.finca
                FROM usuarios_productor up
                INNER JOIN productores p ON up.id_productor = p.id
                WHERE up.nombre_usuario = ?
                AND up.codigo_productor = ?
                AND up.contrasenia = SHA2(CONCAT(?, 'lacteos_salt'), 256)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $codigo_productor, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            // Credenciales correctas
            $usuario = $result->fetch_assoc();
            
            // Establecer variables de sesión
            $_SESSION['productor_id'] = $usuario['id_productor'];
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['productor_nombre'] = $usuario['productor_nombre'];
            $_SESSION['productor_finca'] = $usuario['finca'];
            $_SESSION['productor_username'] = $usuario['nombre_usuario'];
            $_SESSION['productor_codigo'] = $usuario['codigo_productor'];
            $_SESSION['login_time'] = time();
            
            // Redirigir al dashboard
            header('Location: dashboard.php');
            exit();
            
        } else {
            // Credenciales incorrectas
            header('Location: login.php?error=credenciales');
            exit();
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        // Error en la consulta
        error_log("Error en login: " . $e->getMessage());
        header('Location: login.php?error=db_error');
        exit();
    }
    
    $conn->close();
    
} else {
    // Si alguien intenta acceder directamente sin POST
    header('Location: login.php');
    exit();
}
?>