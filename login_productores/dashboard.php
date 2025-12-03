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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
        }

        .header {
            background: linear-gradient(to right, #2c3e50, #3498db);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background-color: #f1c40f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-section {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .welcome-section h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }

        .stat-card.inventory i { color: #3498db; }
        .stat-card.orders i { color: #2ecc71; }
        .stat-card.sales i { color: #9b59b6; }
        .stat-card.clients i { color: #e67e22; }

        .quick-actions {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .quick-actions h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f1f1;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .action-btn {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s;
            cursor: pointer;
        }

        .action-btn:hover {
            border-color: #3498db;
            background-color: #e3f2fd;
            transform: translateY(-3px);
        }

        .action-btn i {
            font-size: 30px;
            margin-bottom: 10px;
            color: #3498db;
        }

        .session-info {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            font-size: 14px;
            color: #7f8c8d;
        }

        .session-info strong {
            color: #2c3e50;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
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