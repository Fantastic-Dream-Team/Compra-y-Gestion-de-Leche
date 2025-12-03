<?php
// includes/views/panel_productor.php

$page_data = [
    'page_title' => 'Lácteos Don Joaquín - Panel del Productor',
    'current_page' => 'panel-productor',
    'assets_path' => BASE_URL . '/assets',
    'base_url' => dirname($_SERVER['SCRIPT_NAME']),
    'current_year' => date('Y')
];

$nombreProductor = ""; // ← se llenará desde BD más adelante
$imagenHeader = $page_data['assets_path'] . "/images/Conferencias-Proveedore.jpg";

$notificaciones = [
    "Tiene una entrega pendiente mañana.",
    "Su pago del 15 de octubre fue procesado.",
    "Nueva actualización disponible.",
    "Se ha actualizado el precio de la leche para noviembre."
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel del Productor - Lácteos Don Joaquín">
    <title><?php echo $page_data['page_title']; ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/reseteo.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styles.css"> <!-- ← ESTA ES LA CLAVE -->
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/panel_productor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- ========== HEADER CON IMAGEN DE FONDO ========== -->
    <header class="header-productor-nuevo" style="background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.6)), url('<?php echo $imagenHeader; ?>') center/cover no-repeat;">
        
        <!-- Franja naranja translúcida superior -->
        <div class="franja-naranja-superior">
            <!-- Logo pequeño -->
            <div class="logo-pequeno">
                <img src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Lácteos Don Joaquín">
            </div>

            <!-- Íconos de notificación y alerta -->
            <div class="contenedor-iconos-derecha">
                <div class="icono-circulo" onclick="togglePanelNotificaciones()">
                    <img src="<?php echo $page_data['assets_path']; ?>/images/notificacion.png" alt="Notificaciones">
                </div>
                <div class="icono-circulo alerta" onclick="togglePanelAlertas()">
                    <img src="<?php echo $page_data['assets_path']; ?>/images/advertencia.png" alt="Alertas">
                </div>
            </div>
        </div>

        <!-- Frase central con fondo redondeado para contraste -->
        <div class="frase-contenedor-centro">
            <div class="frase-contenedor-fondo">
                <h1 class="frase-central">Conoce a los Productores,<br>el Alma de Nuestra Tierra</h1>
            </div>
        </div>
    </header>

    <main>
        <!-- ========== SECCIÓN DEL PRODUCTOR ========== -->
        <section class="seccion-productor" aria-labelledby="titulo-productor">
            <div class="contenedor-productor-nuevo">
                <!-- Lado izquierdo: Imagen de perfil -->
                <div class="columna-productor-izquierda">
                    <div class="foto-perfil-contenedor">
                        <img src="<?php echo $page_data['assets_path']; ?>/images/perfil.png" alt="Foto del Productor" class="foto-perfil">
                    </div>
                </div>

                <!-- Lado derecho: Nombre del usuario -->
                <div class="columna-productor-derecha">
                    <div class="nombre-productor-contenedor" id="titulo-productor">
                        <?php echo $nombreProductor ?: "Nombre del Productor"; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== PANELES LATERALES ========== -->
        <!-- Notificaciones -->
        <aside id="panel-notificaciones" class="panel-lateral" aria-label="Panel de notificaciones">
            <h2>Notificaciones</h2>
            <?php foreach ($notificaciones as $notif): ?>
                <div class="item-notificacion">
                    Info <?php echo htmlspecialchars($notif); ?>
                </div>
            <?php endforeach; ?>
            <button onclick="togglePanelNotificaciones()" class="btn-cerrar-lateral">Cerrar</button>
        </aside>

        <!-- Alertas -->
        <aside id="panel-alertas" class="panel-lateral alerta" aria-label="Panel de alertas">
            <h2>Alertas Importantes</h2>
            <div class="item-notificacion critica">
                Advertencia Entrega pendiente para mañana - 29/11/2025
            </div>
            <div class="item-notificacion critica">
                Advertencia Calidad de grasa por debajo del mínimo
            </div>
            <button onclick="togglePanelAlertas()" class="btn-cerrar-lateral">Cerrar</button>
        </aside>

        <!-- ========== SECCIÓN REGISTRAR ENTREGA ========== -->
        <section class="seccion-entrega" aria-labelledby="titulo-registrar-entrega">
            <div class="contenedor-entrega-nuevo">
                
                <!-- Lado izquierdo: Título + Ícono + Botón -->
                <div class="columna-izquierda">
                    <h2 id="titulo-registrar-entrega">Registrar Nueva Entrega</h2>
                    
                    <div class="icono-camion-grande">
                        <img src="<?php echo $page_data['assets_path']; ?>/images/iconocamionlechita.png" alt="Camión de leche">
                    </div>
                    
                    <button class="btn-registrar" onclick="abrirModalEntrega()">
                        + Registrar Entrega
                    </button>
                </div>

                <!-- Lado derecho: Imagen grande de productos -->
                <div class="columna-derecha">
                    <img src="<?php echo $page_data['assets_path']; ?>/images/cultivos-selectos-cp-1.jpg" 
                        alt="Productos lácteos selectos" class="img-productos-grande">
                </div>
            </div>
        </section>

        <!-- ========== MODAL REGISTRO ENTREGA ========== -->
        <div id="modalEntrega" class="modal" aria-hidden="true" aria-labelledby="modal-titulo">
            <div class="modal-contenido">
                <span class="cerrar" onclick="cerrarModalEntrega()" aria-label="Cerrar modal">×</span>
                <h2 id="modal-titulo">Nueva Entrega</h2>
                <form id="formEntrega">
                    <label for="litros">Litros Entregados:</label>
                    <input type="number" id="litros" step="0.01" required>

                    <label for="grasa">Grasa (%):</label>
                    <input type="number" id="grasa" step="0.01" required>

                    <label for="proteina">Proteína (%):</label>
                    <input type="number" id="proteina" step="0.01" required>

                    <label for="fecha">Fecha de Entrega:</label>
                    <input type="date" id="fecha" required>

                    <button type="submit" class="btn-guardar">Guardar Entrega</button>
                </form>
            </div>
        </div>

        <!-- ========== SECCIÓN GRÁFICAS ========== -->
        <section class="seccion-graficas" aria-labelledby="titulo-estadisticas">
            <h2 id="titulo-estadisticas">Estadísticas</h2>
            <div class="contenedor-graficas">
                <div class="grafica">
                    <h3>Producción Diario/Semanal</h3>
                    <canvas id="grafica1" aria-label="Gráfica de producción diaria/semanal"></canvas>
                </div>
                <div class="grafica">
                    <h3>Pagos Acumulados</h3>
                    <canvas id="grafica2" aria-label="Gráfica de pagos acumulados"></canvas>
                </div>
                <div class="grafica">
                    <h3>Calidad Promedio</h3>
                    <canvas id="grafica3" aria-label="Gráfica de calidad promedio"></canvas>
                </div>
            </div>
        </section>
    </main>

    <!-- ========== FOOTER (Se usa el mismo de styles.css) ========== -->
    <footer class="footer">
        <div class="logo">
            <img src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo Lácteos Don Joaquín" width="150" height="80">
        </div>
        
        <div class="social">
            <a href="#" aria-label="Instagram">Instagram</a>
            <a href="#" aria-label="Facebook">Facebook</a>
            <a href="#" aria-label="WhatsApp">WhatsApp</a>
            <a href="mailto:info@lacteosdonjoaquin.com" aria-label="Correo electrónico">Email</a>
        </div>
        
        <div class="derechos">
            <p>&copy; <?php echo $page_data['current_year']; ?> Lácteos Don Joaquín. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="<?php echo $page_data['assets_path']; ?>/js/panel_productor.js"></script>
</body>
</html>