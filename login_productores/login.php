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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2a3a, #2c3e50);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            width: 100%;
            min-height: 600px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(to bottom right, #2c3e50, #3498db);
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 30px;
            left: 40px;
            font-size: 28px;
            font-weight: bold;
            color: #f1c40f;
        }

        .welcome-text h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: white;
        }

        .welcome-text p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .features {
            list-style: none;
            margin-top: 30px;
        }

        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .features i {
            margin-right: 10px;
            color: #f1c40f;
            font-size: 18px;
        }

        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 15px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        .input-with-icon input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .input-with-icon input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .login-btn {
            background: linear-gradient(to right, #3498db, #2c3e50);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: linear-gradient(to right, #2980b9, #1a252f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .separator {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #95a5a6;
        }

        .separator::before,
        .separator::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .separator span {
            padding: 0 15px;
            font-size: 14px;
        }

        .alternate-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .alt-btn {
            flex: 1;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .alt-btn:hover {
            border-color: #3498db;
            background-color: #f8f9fa;
        }

        .error-message {
            background-color: #ffeaea;
            color: #e74c3c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .forgot-password a {
            color: #3498db;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }
            
            .login-left, .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Panel izquierdo con información -->
        <div class="login-left">
            <div class="logo">
                <i class="fas fa-seedling"></i> AgroProductores
            </div>
            
            <div class="welcome-text">
                <h1>Acceso de Productor</h1>
                <p>Bienvenido al portal exclusivo para productores. Accede a tu cuenta para gestionar tu inventario, ver pedidos y conectar con distribuidores.</p>
                
                <ul class="features">
                    <li><i class="fas fa-check-circle"></i> Gestiona tu inventario en tiempo real</li>
                    <li><i class="fas fa-check-circle"></i> Accede a reportes de ventas detallados</li>
                    <li><i class="fas fa-check-circle"></i> Conéctate directamente con distribuidores</li>
                    <li><i class="fas fa-check-circle"></i> Recibe notificaciones de pedidos nuevos</li>
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
            </form>
            
            <div class="separator">
                <span>O accede con</span>
            </div>
            
            <div class="alternate-login">
                <button class="alt-btn">
                    <i class="fab fa-google" style="color: #DB4437;"></i> Google
                </button>
                <button class="alt-btn">
                    <i class="fab fa-facebook-f" style="color: #4267B2;"></i> Facebook
                </button>
            </div>
            
            <div class="forgot-password">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            
            <div class="footer">
                <p>&copy; 2023 AgroProductores. Todos los derechos reservados.</p>
                <p>Contacto: soporte@agroproductores.com | Tel: +1 234 567 890</p>
            </div>
        </div>
    </div>
    
    <script>
        // Validación básica del formulario antes de enviar
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const username = document.getElementById('username').value;
            const codigo = document.getElementById('codigo').value;
            
            // Validación simple
            if (!email || !password || !username || !codigo) {
                e.preventDefault();
                document.getElementById('errorMessage').textContent = "Por favor completa todos los campos obligatorios.";
                document.getElementById('errorMessage').classList.add('show');
                return false;
            }
            
            // Validación de formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                document.getElementById('errorMessage').textContent = "Por favor ingresa un correo electrónico válido.";
                document.getElementById('errorMessage').classList.add('show');
                return false;
            }
            
            return true;
        });
        
        // Ocultar mensaje de error al empezar a escribir
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const errorMessage = document.getElementById('errorMessage');
                if (errorMessage && errorMessage.classList.contains('show')) {
                    errorMessage.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>