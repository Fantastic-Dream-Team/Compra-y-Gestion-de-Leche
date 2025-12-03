<?php
// Iniciar sesión
session_start();

// Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y limpiar los datos del formulario
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $codigo = trim($_POST['codigo']);
    $password = $_POST['password'];
    
    // Validar que los campos obligatorios no estén vacíos
    if (empty($email) || empty($username) || empty($codigo) || empty($password)) {
        header('Location: login.php?error=vacios');
        exit();
    }
    
    // Validar formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login.php?error=credenciales');
        exit();
    }
    
    // En un sistema real, aquí validaríamos contra una base de datos
    // Por ahora, usaremos credenciales de ejemplo para demostración
    
    // Credenciales de ejemplo (en producción esto vendría de la base de datos)
    $usuarios_validos = [
        [
            'email' => 'productor@ejemplo.com',
            'username' => 'productor1',
            'codigo' => 'PROD001',
            'password' => 'password123', // En producción esto sería un hash
            'nombre' => 'Juan Pérez',
            'id' => 1
        ],
        [
            'email' => 'agricultor@ejemplo.com',
            'username' => 'agricultor2',
            'codigo' => 'PROD002',
            'password' => 'agro2023',
            'nombre' => 'María García',
            'id' => 2
        ]
    ];
    
    // Buscar usuario en el array
    $usuario_valido = false;
    $usuario_datos = [];
    
    foreach ($usuarios_validos as $usuario) {
        if ($usuario['email'] === $email && 
            $usuario['username'] === $username && 
            $usuario['codigo'] === $codigo && 
            $usuario['password'] === $password) {
            $usuario_valido = true;
            $usuario_datos = $usuario;
            break;
        }
    }
    
    if ($usuario_valido) {
        // Guardar datos en sesión
        $_SESSION['productor_id'] = $usuario_datos['id'];
        $_SESSION['productor_nombre'] = $usuario_datos['nombre'];
        $_SESSION['productor_email'] = $usuario_datos['email'];
        $_SESSION['productor_username'] = $usuario_datos['username'];
        $_SESSION['productor_codigo'] = $usuario_datos['codigo'];
        $_SESSION['login_time'] = time();
        
        // Redirigir al dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Credenciales incorrectas
        header('Location: login.php?error=credenciales');
        exit();
    }
} else {
    // Si alguien intenta acceder directamente a este archivo
    header('Location: login.php');
    exit();
}
?>