<?php
// logout.php - VERSIÓN MEJORADA
session_start();

// Registrar el logout
error_log("Usuario " . ($_SESSION['productor_username'] ?? 'desconocido') . " cerró sesión");

// Destruir todas las variables de sesión
$_SESSION = [];

// Borrar la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir la sesión
session_destroy();

// Redirigir a login con parámetro de logout exitoso
header('Location: login.php?logout=exitoso');
exit();
?>