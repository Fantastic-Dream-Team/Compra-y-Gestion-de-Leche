<?php
// dashboard.php modificado
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['productor_id'])) {
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Conectar a la base de datos para obtener datos reales
require_once $_SERVER['DOCUMENT_ROOT'] . '/Compra-y-Gestion-de-Leche/php-src/includes/conexion.php';

// Obtener datos del productor desde la base de datos
$productor_id = $_SESSION['productor_id'];
$sql = "SELECT p.*, up.nombre_usuario, up.codigo_productor
        FROM productores p
        INNER JOIN usuarios_productor up ON p.id = up.id_productor
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productor_id);
$stmt->execute();
$result = $stmt->get_result();
$productor = $result->fetch_assoc();

// Obtener estadísticas reales del productor
$sql_entregas = "SELECT COUNT(*) as total_entregas, 
                        COALESCE(SUM(litros), 0) as total_litros,
                        COALESCE(AVG(CASE 
                            WHEN calidad = 'Excelente' THEN 100
                            WHEN calidad = 'Buena' THEN 80
                            WHEN calidad = 'Regular' THEN 60
                            WHEN calidad = 'Deficiente' THEN 40
                            ELSE 0 
                        END), 0) as promedio_calidad
                 FROM entregas 
                 WHERE id_usuario_productor = (SELECT id FROM usuarios_productor WHERE id_productor = ?)";
$stmt2 = $conn->prepare($sql_entregas);
$stmt2->bind_param("i", $productor_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$estadisticas = $result2->fetch_assoc();

// Calcular tiempo de sesión
$tiempo_sesion = time() - $_SESSION['login_time'];
$horas = floor($tiempo_sesion / 3600);
$minutos = floor(($tiempo_sesion % 3600) / 60);

$stmt->close();
$stmt2->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Productor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Compra-y-Gestion-de-Leche/php-src/assets/css/dashboard.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <i class="fas fa-seedling"></i>
            <span>Productores Don Joaquin - Panel de Control</span>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['productor_nombre'], 0, 1)); ?>
            </div>
            <div>
                <div class="user-name"><?php echo htmlspecialchars($_SESSION['productor_nombre']); ?></div>
                <div class="user-email">Finca: <?php echo htmlspecialchars($_SESSION['productor_finca']); ?></div>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </header>
    
    <div class="container">
        <div class="welcome-section">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['productor_nombre']); ?></h1>
            <p>Desde aquí puedes gestionar tus entregas, ver pedidos activos y más.</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card inventory">
                <i class="fas fa-boxes"></i>
                <h3>Entregas Realizadas</h3>
                <div class="value"><?php echo $estadisticas['total_entregas'] ?? 0; ?></div>
            </div>
            
            <div class="stat-card orders">
                <i class="fas fa-clipboard-list"></i>
                <h3>Total Litros</h3>
                <div class="value"><?php echo number_format($estadisticas['total_litros'] ?? 0, 0); ?> L</div>
            </div>
            
            <div class="stat-card sales">
                <i class="fas fa-chart-line"></i>
                <h3>Calidad Promedio</h3>
                <div class="value"><?php echo number_format($estadisticas['promedio_calidad'] ?? 0, 1); ?>%</div>
            </div>
            
            <div class="stat-card clients">
                <i class="fas fa-users"></i>
                <h3>Especialidad</h3>
                <div class="value"><?php echo htmlspecialchars($productor['especialidad'] ?? 'No disponible'); ?></div>
            </div>
        </div>
        
        <!-- Sección de Acciones Rápidas -->
        <div class="quick-actions">
            <h2>Acciones Rápidas</h2>
            <div class="actions-grid">
                <button type="button" class="action-btn" onclick="openModal('notificacionesModal')">
                    <i class="fas fa-bell"></i>
                    <span>Notificaciones</span>
                </button>
                
                <button type="button" class="action-btn" onclick="openModal('registrarEntregaModal')">
                    <i class="fas fa-truck"></i>
                    <span>Registrar nueva entrega</span>
                </button>
                
                <button type="button" class="action-btn" onclick="openModal('estadisticasModal')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Estadísticas</span>
                </button>
            </div>
        </div>
        
        <!-- Modal de Notificaciones (SIN MODIFICAR - MANTENIENDO FUNCIONALIDAD ORIGINAL) -->
        <div id="notificacionesModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Notificaciones</h2>
                    <span class="close" onclick="closeModal('notificacionesModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <ul class="notificaciones-list">
                        <?php
                        // Notificaciones reales basadas en estadísticas
                        $notificaciones = [];
                        
                        if ($estadisticas['total_entregas'] > 0) {
                            $notificaciones[] = [
                                'id' => 1,
                                'mensaje' => 'Tienes ' . $estadisticas['total_entregas'] . ' entregas registradas',
                                'fecha' => date('Y-m-d H:i'),
                                'leida' => false
                            ];
                            
                            $notificaciones[] = [
                                'id' => 2,
                                'mensaje' => 'Total de ' . number_format($estadisticas['total_litros'], 0) . ' litros entregados',
                                'fecha' => date('Y-m-d H:i', strtotime('-1 day')),
                                'leida' => true
                            ];
                            
                            $notificaciones[] = [
                                'id' => 3,
                                'mensaje' => 'Calidad promedio: ' . number_format($estadisticas['promedio_calidad'], 1) . '%',
                                'fecha' => date('Y-m-d H:i', strtotime('-2 days')),
                                'leida' => true
                            ];
                        } else {
                            $notificaciones[] = [
                                'id' => 1,
                                'mensaje' => 'Aún no has registrado entregas. ¡Registra tu primera entrega!',
                                'fecha' => date('Y-m-d H:i'),
                                'leida' => false
                            ];
                        }
                        
                        $notificaciones[] = [
                            'id' => 4,
                            'mensaje' => 'Especialidad: ' . htmlspecialchars($productor['especialidad'] ?? 'No definida'),
                            'fecha' => date('Y-m-d H:i', strtotime('-3 days')),
                            'leida' => true
                        ];
                        
                        $notificaciones[] = [
                            'id' => 5,
                            'mensaje' => 'Producción: ' . htmlspecialchars($productor['produccion'] ?? 'No definida'),
                            'fecha' => date('Y-m-d H:i', strtotime('-4 days')),
                            'leida' => true
                        ];
                        
                        foreach ($notificaciones as $notificacion):
                        ?>
                        <li class="notificacion-item <?php echo $notificacion['leida'] ? 'leida' : 'no-leida'; ?>">
                            <div class="notificacion-icon">
                                <i class="fas fa-<?php echo $notificacion['leida'] ? 'envelope-open' : 'envelope'; ?>"></i>
                            </div>
                            <div class="notificacion-content">
                                <p class="notificacion-mensaje"><?php echo htmlspecialchars($notificacion['mensaje']); ?></p>
                                <span class="notificacion-fecha"><?php echo $notificacion['fecha']; ?></span>
                            </div>
                            <?php if (!$notificacion['leida']): ?>
                            <div class="notificacion-actions">
                                <button class="btn-marcar-leida" onclick="marcarComoLeida(<?php echo $notificacion['id']; ?>)">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('notificacionesModal')">Cerrar</button>
                    <button class="btn btn-primary" onclick="marcarTodasLeidas()">Marcar todas como leídas</button>
                </div>
            </div>
        </div>

        <!-- Modal de Registrar Nueva Entrega (CON CONEXIÓN REAL A BD) -->
<div id="registrarEntregaModal" class="modal" style="display: none;">
    <div class="modal-content">
        <form id="formRegistrarEntrega" action="procesar_entrega.php" method="POST">
            <div class="modal-header">
                <h2>Registrar Nueva Entrega</h2>
                <span class="close" onclick="closeModal('registrarEntregaModal')">&times;</span>
            </div>
            <div class="modal-body">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                
                <div class="form-group">
                    <label for="litros"><i class="fas fa-gas-pump"></i> Litros de Leche *</label>
                    <input type="number" id="litros" name="litros" step="0.01" min="0.1" max="1000" required 
                           placeholder="Ingrese la cantidad en litros (ej: 150.5)">
                </div>
                
                <div class="form-group">
                    <label for="calidad"><i class="fas fa-star"></i> Calidad *</label>
                    <select id="calidad" name="calidad" required>
                        <option value="">Seleccione la calidad</option>
                        <option value="Excelente">Excelente</option>
                        <option value="Buena">Buena</option>
                        <option value="Regular">Regular</option>
                        <option value="Deficiente">Deficiente</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha de Entrega *</label>
                    <input type="date" id="fecha" name="fecha" required 
                           value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="observaciones"><i class="fas fa-sticky-note"></i> Observaciones (Opcional)</label>
                    <textarea id="observaciones" name="observaciones" 
                              placeholder="Observaciones adicionales sobre la entrega (ej: temperatura, color, etc.)"
                              rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('registrarEntregaModal')">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Entrega
                </button>
            </div>
        </form>
    </div>
</div>

        <!-- Modal de Estadísticas (CON INFORMACIÓN REAL DE LA BD) -->
        <div id="estadisticasModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Estadísticas de Producción</h2>
                    <span class="close" onclick="closeModal('estadisticasModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="estadisticas-container">
                        <div class="estadistica-item">
                            <h3>Producción Mensual</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; color: #3498db; margin: 10px 0;">
                                    <?php echo number_format($estadisticas['total_litros'] ?? 0, 0); ?> L
                                </div>
                                <p>Total de litros entregados</p>
                            </div>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Calidad por Entregas</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; color: #2ecc71; margin: 10px 0;">
                                    <?php echo number_format($estadisticas['promedio_calidad'] ?? 0, 1); ?>%
                                </div>
                                <p>Calidad promedio</p>
                            </div>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Tendencias</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; color: #e74c3c; margin: 10px 0;">
                                    <?php echo $estadisticas['total_entregas'] ?? 0; ?>
                                </div>
                                <p>Entregas realizadas</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h3>Información del Productor</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                            <div>
                                <p><strong>Finca:</strong> <?php echo htmlspecialchars($productor['finca'] ?? 'No definida'); ?></p>
                                <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($productor['ubicacion'] ?? 'No definida'); ?></p>
                                <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($productor['especialidad'] ?? 'No definida'); ?></p>
                            </div>
                            <div>
                                <p><strong>Producción:</strong> <?php echo htmlspecialchars($productor['produccion'] ?? 'No definida'); ?></p>
                                <p><strong>Salud Animal:</strong> <?php echo htmlspecialchars($productor['salud_animal'] ?? 'No definida'); ?></p>
                                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($productor['nombre_usuario'] ?? 'No definido'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('estadisticasModal')">Cerrar</button>
                </div>
            </div>
        </div>
        
        <div class="session-info">
            <p><strong>Información de Sesión:</strong></p>
            <p>Usuario: <?php echo htmlspecialchars($_SESSION['productor_username']); ?></p>
            <p>Código de Productor: <?php echo htmlspecialchars($_SESSION['productor_codigo']); ?></p>
            <p>Finca: <?php echo htmlspecialchars($_SESSION['productor_finca']); ?></p>
            <p>Tiempo de sesión activa: <?php echo $horas; ?> horas y <?php echo $minutos; ?> minutos</p>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 Don Joaquin. Panel de Control para Productores.</p>
        <p>Si necesitas ayuda, contacta a soporte: soporte@donjoaquin.com</p>
    </div>

    <!-- Incluir JavaScript -->
    <script src="/Compra-y-Gestion-de-Leche/php-src/assets/js/dashboard.js"></script>
    <script>
    // Función para registrar entrega (MANTENIENDO FUNCIONALIDAD ORIGINAL)
    function registrarEntrega() {
        event.preventDefault(); // Prevenir envío real del formulario
        
        // Obtener valores del formulario
        var litros = document.getElementById('litros').value;
        var calidad = document.getElementById('calidad').value;
        var fecha = document.getElementById('fecha').value;
        var observaciones = document.getElementById('observaciones').value;
        
        // Validar datos
        if (!litros || litros <= 0) {
            alert('Por favor ingrese una cantidad de litros válida');
            return false;
        }
        
        if (!calidad) {
            alert('Por favor seleccione la calidad');
            return false;
        }
        
        if (!fecha) {
            alert('Por favor seleccione la fecha de entrega');
            return false;
        }
        
        // Mostrar resumen de la entrega
        var resumen = 
            "¡Entrega registrada exitosamente!\n\n" +
            "Resumen:\n" +
            "• Litros: " + litros + " L\n" +
            "• Calidad: " + calidad + "\n" +
            "• Fecha: " + fecha + "\n";
            
        if (observaciones) {
            resumen += "• Observaciones: " + observaciones + "\n";
        }
        
        resumen += "\nNota: En producción real, estos datos se guardarían en la base de datos.";
        
        alert(resumen);
        
        // Cerrar modal
        closeModal('registrarEntregaModal');
        
        // Limpiar formulario
        document.getElementById('formRegistrarEntrega').reset();
        
        // Restablecer fecha actual
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('fecha').value = now.toISOString().slice(0,16);
        
        return false;
    }
    
    // Asegurar que dashboard.js se cargue correctamente
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar fecha por defecto en el formulario de entrega
        var fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            fechaInput.value = now.toISOString().slice(0,16);
        }
        
        // Agregar validación adicional si es necesario
        var formRegistrarEntrega = document.getElementById('formRegistrarEntrega');
        if (formRegistrarEntrega) {
            formRegistrarEntrega.addEventListener('submit', function(e) {
                // Aquí podrías agregar validación adicional si lo necesitas
                // Pero manteniendo la funcionalidad original del alert
                return true;
            });
        }
    });
    </script>
</body>
</html>