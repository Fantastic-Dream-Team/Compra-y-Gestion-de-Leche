<?php
// Iniciamos sesión para mantener el estado del usuario
session_start();

// Si el usuario ya está logueado, redirigir al dashboard
if (isset($_SESSION['productor_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso de Productor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Compra-y-Gestion-de-Leche/php-src/assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <!-- Panel izquierdo con información -->
        <div class="login-left">
            <div class="logo">
                <i class="fas fa-seedling"></i> Don Joaquin
            </div>
            
            <div class="welcome-text">
                <h1>Acceso de Productor</h1>
                <p>Bienvenido a este portal</p>
                
                <ul class="features">
                    <li><i class="fas fa-check-circle"></i> Gestiona tus entregas de leche</li>
                    <li><i class="fas fa-check-circle"></i> Analiza estadísticas de producción</li>
                    <li><i class="fas fa-check-circle"></i> Recibe notificaciones en tiempo real</li>
                </ul>
            </div>
        </div>
        
        <!-- Panel derecho con formulario -->
        <div class="login-right">
            <div class="login-header">
                <h2>Ingresa las Credenciales</h2>
                <p>Ingresa tus datos para acceder a tu cuenta de productor</p>
            </div>
            
            <!-- Mostrar mensaje de error si existe -->
            <?php if (isset($_GET['error'])): ?>
            <div class="error-message show" id="errorMessage">
                <i class="fas fa-exclamation-circle"></i>
                <?php 
                    if ($_GET['error'] == 'credenciales') {
                        echo "Correo electrónico o contraseña incorrectos.";
                    } elseif ($_GET['error'] == 'vacios') {
                        echo "Por favor completa todos los campos.";
                    } elseif ($_GET['error'] == 'sesion_expirada') {
                        echo "Tu sesión ha expirado. Por favor inicia sesión nuevamente.";
                    }
                ?>
            </div>
            <?php endif; ?>
            
            <form action="procesar_login.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="ejemplo@productor.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="username">Nombre de Usuario</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Tu nombre de usuario" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="phone" name="phone" placeholder="Número de teléfono">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="codigo">Código de Productor Asociado</label>
                    <div class="input-with-icon">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="codigo" name="codigo" placeholder="Código único de productor" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>

                <a href="includes/views/home.php" class="volver-btn">
                    <i class="fas fa-home"></i> Volver a la página principal
                </a>

            </form>
            
            <div class="footer">
                <p>&copy; 2025 Don Joaquin. Todos los derechos reservados.</p>
                <p>Contacto: soporte@donjoaquin.com </p>
            </div>
        </div>
    </div>
    
    <script src="/Compra-y-Gestion-de-Leche/php-src/assets/js/login.js"></script>
</body>
</html>