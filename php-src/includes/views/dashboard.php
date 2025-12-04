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
            <p>Desde aquí puedes gestionar tus entregas, ver pedidos activos y más.</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card inventory">
                <i class="fas fa-boxes"></i>
                <h3>Entregas Realizadas</h3>
                <div class="value">1,248</div>
            </div>
            
            <div class="stat-card orders">
                <i class="fas fa-clipboard-list"></i>
                <h3>Pedidos Activos</h3>
                <div class="value">10</div>
            </div>
            
            <div class="stat-card sales">
                <i class="fas fa-chart-line"></i>
                <h3>Ventas Este Mes</h3>
                <div class="value">$24,580</div>
            </div>
            
            <div class="stat-card clients">
                <i class="fas fa-users"></i>
                <h3>Entregas en Curso</h3>
                <div class="value">5</div>
            </div>
        </div>
        
        <!-- Sección de Acciones Rápidas -->
        <div class="quick-actions">
            <h2>Acciones Rápidas</h2>
            <div class="actions-grid">
                <button type="button" class="action-btn" onclick="openModal('notificacionesModal')">
                    <i class="fas fa-box-open"></i>
                    <span>Notificaciones</span>
                </button>
                
                <button type="button" class="action-btn" onclick="openModal('registrarEntregaModal')">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Registrar nueva entrega</span>
                </button>
                
                <button type="button" class="action-btn" onclick="openModal('estadisticasModal')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Estadísticas</span>
                </button>
            </div>
        </div>
        
        <!-- Modal de Notificaciones -->
        <div id="notificacionesModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Notificaciones</h2>
                    <span class="close" onclick="closeModal('notificacionesModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <ul class="notificaciones-list">
                        <?php
                        // Simulación de notificaciones
                        $notificaciones = [
                            [
                                'id' => 1,
                                'mensaje' => 'Entrega registrada exitosamente - 120 litros',
                                'fecha' => '2024-01-15 10:30',
                                'leida' => false
                            ],
                            [
                                'id' => 2,
                                'mensaje' => 'Próxima entrega programada para mañana',
                                'fecha' => '2024-01-14 14:20',
                                'leida' => true
                            ],
                            [
                                'id' => 3,
                                'mensaje' => 'Recordatorio: Actualizar datos de producción',
                                'fecha' => '2024-01-13 09:15',
                                'leida' => true
                            ],
                            [
                                'id' => 4,
                                'mensaje' => 'Nuevo distribuidor interesado en tu producción',
                                'fecha' => '2024-01-12 16:45',
                                'leida' => false
                            ],
                            [
                                'id' => 5,
                                'mensaje' => 'Análisis de calidad completado - Calificación: Excelente',
                                'fecha' => '2024-01-11 11:00',
                                'leida' => true
                            ]
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

        <!-- Modal de Registrar Nueva Entrega (SIN CONEXIÓN A BD) -->
        <div id="registrarEntregaModal" class="modal" style="display: none;">
            <div class="modal-content">
                <form id="formRegistrarEntrega" onsubmit="return registrarEntrega()">
                    <div class="modal-header">
                        <h2>Registrar Nueva Entrega</h2>
                        <span class="close" onclick="closeModal('registrarEntregaModal')">&times;</span>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_usuario_productor" value="<?php echo $_SESSION['productor_id'] ?? 1; ?>">
                        
                        <div class="form-group">
                            <label for="litros"><i class="fas fa-gas-pump"></i> Litros de Leche</label>
                            <input type="number" id="litros" name="litros" step="0.01" min="0" required 
                                   placeholder="Ingrese la cantidad en litros">
                        </div>
                        
                        <div class="form-group">
                            <label for="calidad"><i class="fas fa-star"></i> Calidad</label>
                            <select id="calidad" name="calidad" required>
                                <option value="">Seleccione la calidad</option>
                                <option value="Excelente">Excelente</option>
                                <option value="Buena">Buena</option>
                                <option value="Regular">Regular</option>
                                <option value="Deficiente">Deficiente</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha de Entrega</label>
                            <input type="datetime-local" id="fecha" name="fecha" required 
                                   value="<?php echo date('Y-m-d\TH:i'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="observaciones"><i class="fas fa-sticky-note"></i> Observaciones (Opcional)</label>
                            <textarea id="observaciones" name="observaciones" 
                                      placeholder="Observaciones adicionales sobre la entrega"></textarea>
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

        <!-- Modal de Estadísticas -->
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
                            <img src="/Compra-y-Gestion-de-Leche/php-src/assets/images/grafico-produccion-mensual.png" 
                                 alt="Gráfico de producción mensual" class="estadistica-img" onerror="this.src='https://via.placeholder.com/300x200/3498db/ffffff?text=Gráfico+Producción+Mensual'">
                            <p class="estadistica-desc">Evolución de la producción de leche en los últimos meses</p>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Calidad por Entregas</h3>
                            <img src="/Compra-y-Gestion-de-Leche/php-src/assets/images/grafico-calidad.png" 
                                 alt="Gráfico de calidad" class="estadistica-img" onerror="this.src='https://via.placeholder.com/300x200/2ecc71/ffffff?text=Gráfico+Calidad'">
                            <p class="estadistica-desc">Distribución de calificaciones de calidad</p>
                        </div>
                        
                        <div class="estadistica-item">
                            <h3>Tendencias Anuales</h3>
                            <img src="/Compra-y-Gestion-de-Leche/php-src/assets/images/grafico-tendencias.png" 
                                 alt="Gráfico de tendencias anuales" class="estadistica-img" onerror="this.src='https://via.placeholder.com/300x200/e74c3c/ffffff?text=Gráfico+Tendencias'">
                            <p class="estadistica-desc">Comparativa año actual vs año anterior</p>
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
    // Función para registrar entrega (solo muestra alerta)
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
    <script src="/Compra-y-Gestion-de-Leche/php-src/assets/js/dashboard.js"></script>
</body>
</html>