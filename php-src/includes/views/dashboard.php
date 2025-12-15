<?php
// dashboard.php - VERSIÓN FUNCIONAL MODIFICADA
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['productor_id'])) {
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Conectar a la base de datos para obtener datos reales
require_once $_SERVER['DOCUMENT_ROOT'] . '/Compra-y-Gestion-de-Leche/php-src/includes/conexion.php';

// Obtener ID del usuario_productor desde la sesión
$usuario_productor_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_productor_id) {
    session_destroy();
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Obtener datos del productor con los campos correctos
$sql = "SELECT p.*, up.id as usuario_productor_id, up.nombre_usuario, up.codigo_productor
        FROM productores p
        INNER JOIN usuarios_productor up ON p.id = up.id_productor
        WHERE up.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_productor_id);
$stmt->execute();
$result = $stmt->get_result();
$productor = $result->fetch_assoc();

// Si no se encuentra el productor, redirigir
if (!$productor) {
    session_destroy();
    header('Location: login.php?error=sesion_expirada');
    exit();
}

// Obtener estadísticas reales del productor (CORREGIDO)
$sql_entregas = "SELECT 
    (SELECT COUNT(*) FROM entregas WHERE id_usuario_productor = ?) as total_entregas,
    (SELECT COALESCE(SUM(litros), 0) FROM entregas WHERE id_usuario_productor = ?) as total_litros,
    (SELECT COALESCE(AVG(CASE 
        WHEN calidad = 'Excelente' THEN 100
        WHEN calidad = 'Óptima' THEN 90
        WHEN calidad = 'Buena' THEN 80
        WHEN calidad = 'Regular' THEN 60
        WHEN calidad = 'Deficiente' THEN 40
        ELSE 0 
    END), 0) FROM entregas WHERE id_usuario_productor = ?) as promedio_calidad
FROM DUAL";

$stmt2 = $conn->prepare($sql_entregas);
$stmt2->bind_param("iii", $usuario_productor_id, $usuario_productor_id, $usuario_productor_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$estadisticas = $result2->fetch_assoc();

// Obtener notificaciones reales de la base de datos
$notificaciones_reales = [];
$sql_notificaciones = "SELECT 
                        n.id,
                        n.mensaje,
                        n.fecha_creacion,
                        n.leida,
                        tn.titulo,
                        tn.prioridad,
                        n.datos_contexto
                    FROM notificaciones n
                    INNER JOIN tipos_notificaciones tn ON n.id_tipo_notificacion = tn.id
                    WHERE n.id_usuario_productor = ?
                    ORDER BY n.leida ASC, n.fecha_creacion DESC
                    LIMIT 20";
    
$stmt_notif = $conn->prepare($sql_notificaciones);
$stmt_notif->bind_param("i", $usuario_productor_id);
$stmt_notif->execute();
$result_notif = $stmt_notif->get_result();
    
while ($notificacion = $result_notif->fetch_assoc()) {
    $notificaciones_reales[] = $notificacion;
}

// Calcular tiempo de sesión
$tiempo_sesion = time() - $_SESSION['login_time'];
$horas = floor($tiempo_sesion / 3600);
$minutos = floor(($tiempo_sesion % 3600) / 60);

$stmt->close();
$stmt2->close();
$stmt_notif->close();
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
        
        <!-- Modal de Notificaciones (ACTUALIZADO CON DATOS REALES DE BD Y FUNCIONALIDAD AJAX) -->
        <div id="notificacionesModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <i class="fas fa-bell"></i> Notificaciones
                        <?php if (count($notificaciones_reales) > 0): ?>
                            <span class="badge"><?php echo count($notificaciones_reales); ?></span>
                        <?php endif; ?>
                    </h2>
                    <span class="close" onclick="closeModal('notificacionesModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <?php if (count($notificaciones_reales) > 0): ?>
                        <div class="notificaciones-stats">
                            <?php 
                            $nuevas = count(array_filter($notificaciones_reales, fn($n) => !$n['leida']));
                            ?>
                            <span class="badge new">
                                <i class="fas fa-envelope"></i> 
                                <?php echo $nuevas; ?> nuevas
                            </span>
                            <span class="badge total">
                                <i class="fas fa-list"></i> 
                                <?php echo count($notificaciones_reales); ?> total
                            </span>
                        </div>
                        
                        <ul class="notificaciones-list">
                            <?php foreach ($notificaciones_reales as $notificacion): ?>
                            <li class="notificacion-item <?php echo $notificacion['leida'] ? 'leida' : 'no-leida'; ?>" 
                                data-id="<?php echo $notificacion['id']; ?>">
                                <div class="notificacion-icon">
                                    <i class="fas fa-<?php echo $notificacion['leida'] ? 'envelope-open' : 'envelope'; ?>"></i>
                                </div>
                                <div class="notificacion-content">
                                    <h4><?php echo htmlspecialchars($notificacion['titulo'] ?? 'Notificación'); ?></h4>
                                    <p class="notificacion-mensaje"><?php echo htmlspecialchars($notificacion['mensaje']); ?></p>
                                    <span class="notificacion-fecha">
                                        <i class="far fa-clock"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($notificacion['fecha_creacion'])); ?>
                                    </span>
                                </div>
                                <?php if (!$notificacion['leida']): ?>
                                <div class="notificacion-actions">
                                    <button class="btn-marcar-leida" onclick="marcarComoLeida(<?php echo $notificacion['id']; ?>, this)">
                                        <i class="fas fa-check"></i> Marcar como leída
                                    </button>
                                </div>
                                <?php else: ?>
                                <div class="notificacion-actions">
                                    <button class="btn-marcar-no-leida" onclick="marcarComoNoLeida(<?php echo $notificacion['id']; ?>, this)">
                                        <i class="fas fa-envelope"></i> Marcar como no leída
                                    </button>
                                </div>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="far fa-bell-slash" style="font-size: 48px; color: #bdc3c7; margin-bottom: 20px;"></i>
                            <h3>No hay notificaciones</h3>
                            <p>No tienes notificaciones pendientes en este momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('notificacionesModal')">Cerrar</button>
                    <?php if (count($notificaciones_reales) > 0): ?>
                    <button class="btn btn-primary" onclick="marcarTodasLeidas()">Marcar todas como leídas</button>
                    <?php endif; ?>
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
                        <input type="hidden" name="usuario_id" value="<?php echo $usuario_productor_id; ?>">
                        
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
                            <h3>Producción Total</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; color: #3498db; margin: 10px 0;">
                                    <?php echo number_format($estadisticas['total_litros'] ?? 0, 0); ?> L
                                </div>
                                <p>Litros entregados en total</p>
                            </div>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Calidad Promedio</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; color: #2ecc71; margin: 10px 0;">
                                    <?php echo number_format($estadisticas['promedio_calidad'] ?? 0, 1); ?>%
                                </div>
                                <p>Calidad promedio de entregas</p>
                            </div>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Entregas Totales</h3>
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
    
    // Función para marcar notificación como leída (CON AJAX REAL)
    function marcarComoLeida(idNotificacion, buttonElement) {
        fetch('marcar_notificaciones.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=marcar_leida&id=' + idNotificacion
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la interfaz
                const notificacionItem = buttonElement.closest('.notificacion-item');
                notificacionItem.classList.remove('no-leida');
                notificacionItem.classList.add('leida');
                
                // Cambiar icono (verde para no leída, gris para leída)
                const icon = notificacionItem.querySelector('.notificacion-icon i');
                icon.className = 'fas fa-envelope-open';
                icon.style.color = '#95a5a6';
                
                // Cambiar botón
                buttonElement.outerHTML = `
                    <button class="btn-marcar-no-leida" onclick="marcarComoNoLeida(${idNotificacion}, this)">
                        <i class="fas fa-envelope"></i> Marcar como no leída
                    </button>`;
                
                // Actualizar contador
                actualizarContadorNotificaciones();
            } else {
                alert('Error: ' + (data.message || 'No se pudo marcar como leída'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    }

    // Función para marcar notificación como NO leída (CON AJAX REAL)
    function marcarComoNoLeida(idNotificacion, buttonElement) {
        fetch('marcar_notificaciones.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=marcar_no_leida&id=' + idNotificacion
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la interfaz
                const notificacionItem = buttonElement.closest('.notificacion-item');
                notificacionItem.classList.remove('leida');
                notificacionItem.classList.add('no-leida');
                
                // Cambiar icono (verde para no leída)
                const icon = notificacionItem.querySelector('.notificacion-icon i');
                icon.className = 'fas fa-envelope';
                icon.style.color = '#2ecc71';
                
                // Cambiar botón
                buttonElement.outerHTML = `
                    <button class="btn-marcar-leida" onclick="marcarComoLeida(${idNotificacion}, this)">
                        <i class="fas fa-check"></i> Marcar como leída
                    </button>`;
                
                // Actualizar contador
                actualizarContadorNotificaciones();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    }

    // Función para marcar TODAS las notificaciones como leídas
    function marcarTodasLeidas() {
        if (!confirm('¿Marcar todas las notificaciones como leídas?')) return;
        
        fetch('marcar_notificaciones.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=marcar_todas_leidas'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar todas las notificaciones en la interfaz
                document.querySelectorAll('.notificacion-item.no-leida').forEach(item => {
                    item.classList.remove('no-leida');
                    item.classList.add('leida');
                    
                    // Cambiar icono
                    const icon = item.querySelector('.notificacion-icon i');
                    if (icon) {
                        icon.className = 'fas fa-envelope-open';
                        icon.style.color = '#95a5a6';
                    }
                    
                    // Cambiar botón
                    const actionsDiv = item.querySelector('.notificacion-actions');
                    if (actionsDiv) {
                        const notificacionId = item.getAttribute('data-id');
                        actionsDiv.innerHTML = `
                            <button class="btn-marcar-no-leida" onclick="marcarComoNoLeida(${notificacionId}, this)">
                                <i class="fas fa-envelope"></i> Marcar como no leída
                            </button>`;
                    }
                });
                
                // Actualizar contador
                actualizarContadorNotificaciones();
                alert('Todas las notificaciones han sido marcadas como leídas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    }

    // Función para actualizar contador de notificaciones
    function actualizarContadorNotificaciones() {
        const nuevas = document.querySelectorAll('.notificacion-item.no-leida').length;
        const total = document.querySelectorAll('.notificacion-item').length;
        
        // Actualizar badge en el header
        const badgeNew = document.querySelector('.badge.new');
        if (badgeNew) badgeNew.innerHTML = `<i class="fas fa-envelope"></i> ${nuevas} nuevas`;
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
        
        // Actualizar contador inicial de notificaciones
        actualizarContadorNotificaciones();
    });
    </script>
</body>
</html>