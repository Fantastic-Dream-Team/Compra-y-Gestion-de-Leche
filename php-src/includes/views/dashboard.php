<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['productor_id'])) {
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Calcular tiempo de sesión
$tiempo_sesion = time() - $_SESSION['login_time'];
$horas = floor($tiempo_sesion / 3600);
$minutos = floor(($tiempo_sesion % 3600) / 60);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Productor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <i class="fas fa-seedling"></i>
            <span>AgroProductores - Panel de Control</span>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['productor_nombre'], 0, 1)); ?>
            </div>
            <div>
                <div class="user-name"><?php echo htmlspecialchars($_SESSION['productor_nombre']); ?></div>
                <div class="user-email"><?php echo htmlspecialchars($_SESSION['productor_email']); ?></div>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </header>
    
    <div class="container">
        <div class="welcome-section">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['productor_nombre']); ?></h1>
            <p>Desde aquí puedes gestionar tu inventario, ver pedidos, generar reportes y más.</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card inventory">
                <i class="fas fa-boxes"></i>
                <h3>Productos en Inventario</h3>
                <div class="value">1,248</div>
            </div>
            
            <div class="stat-card orders">
                <i class="fas fa-clipboard-list"></i>
                <h3>Pedidos Activos</h3>
                <div class="value">47</div>
            </div>
            
            <div class="stat-card sales">
                <i class="fas fa-chart-line"></i>
                <h3>Ventas Este Mes</h3>
                <div class="value">$24,580</div>
            </div>
            
            <div class="stat-card clients">
                <i class="fas fa-users"></i>
                <h3>Distribuidores</h3>
                <div class="value">12</div>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2>Acciones Rápidas</h2>
            <div class="actions-grid">
                <a href="#" class="action-btn">
                    <i class="fas fa-box-open"></i>
                    <span>Gestionar Inventario</span>
                </a>
                
                <a href="#" class="action-btn">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Ver Pedidos</span>
                </a>
                
                <a href="#" class="action-btn">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes de Ventas</span>
                </a>
                
                <a href="#" class="action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Agregar Distribuidor</span>
                </a>
                
                <a href="#" class="action-btn">
                    <i class="fas fa-cogs"></i>
                    <span>Configuración</span>
                </a>
                
                <a href="#" class="action-btn">
                    <i class="fas fa-question-circle"></i>
                    <span>Soporte</span>
                </a>
            </div>
        </div>
        
        <div class="session-info">
            <p><strong>Información de Sesión:</strong></p>
            <p>Usuario: <?php echo htmlspecialchars($_SESSION['productor_username']); ?></p>
            <p>Código de Productor: <?php echo htmlspecialchars($_SESSION['productor_codigo']); ?></p>
            <p>Tiempo de sesión activa: <?php echo $horas; ?> horas y <?php echo $minutos; ?> minutos</p>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2023 AgroProductores. Panel de Control para Productores.</p>
        <p>Si necesitas ayuda, contacta a soporte: soporte@agroproductores.com</p>
    </div>
</body>
</html>