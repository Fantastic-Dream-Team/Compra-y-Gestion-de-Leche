<?php

require_once BASE_PATH . '/includes/conexion.php';

// ====== CARGA DE PRODUCTORES DESDE LA BASE DE DATOS ======
$sql = "SELECT p.*, 
               COALESCE(MAX(e.fecha), 'Nunca') as ultima_entrega
        FROM productores p
        LEFT JOIN usuarios_productor up ON p.id = up.id_productor
        LEFT JOIN entregas e ON up.id = e.id_usuario_productor
        GROUP BY p.id
        ORDER BY p.nombre ASC";

$result_productores = $conn->query($sql);
$productores = [];
$notificaciones = [];

if ($result_productores && $result_productores->num_rows > 0) {
  while ($row = $result_productores->fetch_assoc()) {
    $productores[] = $row;

    // Notificación si no ha entregado en más de 3 días
    if (
      $row['ultima_entrega'] == 'Nunca' ||
      (time() - strtotime($row['ultima_entrega'])) > (3 * 24 * 60 * 60)
    ) {
      $dias = $row['ultima_entrega'] == 'Nunca' ? 'nunca' : floor((time() - strtotime($row['ultima_entrega'])) / 86400);
      $notificaciones[] = "Alerta: {$row['nombre']} ({$row['finca']}) no entrega desde hace $dias días";
    }
  }
}

// ====== REGISTRO DE NUEVA ENTREGA
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_entrega'])) {
  $id_usuario_productor = $_POST['id_usuario_productor'];
  $litros = floatval($_POST['litros']);
  $calidad = $_POST['calidad'];
  $fecha = $_POST['fecha'];

  $stmt = $conn->prepare("INSERT INTO entregas (id_usuario_productor, litros, calidad, fecha) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("idss", $id_usuario_productor, $litros, $calidad, $fecha);

  if ($stmt->execute()) {
    echo "<script>alert('Entrega registrada correctamente');</script>";

    // Recargar página para actualizar notificaciones y carrusel
    echo "<script>window.location.reload();</script>";
  } else {
    echo "<script>alert('Error al registrar entrega');</script>";
  }
  $stmt->close();
}

// Configuración de rutas
$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$assets = $base_url . '/assets';

$page_data = [
  'page_title' => 'Lácteos Don Joaquín - Nuestros Productores',
  'current_page' => 'productores',
  'assets_path' => $assets,
  'base_url' => $base_url,
  'current_year' => date('Y')
];
?>

<!DOCTYPE html>
<html lang="es">
<html lang="es" data-assets-path="<?php echo $page_data['assets_path']; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_data['page_title']; ?></title>
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/reseteo.css">
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styles.css">
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styleProductores.css">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="top-bar"></div>
    <div id="barra-negra"></div>
    <div id="barra-principal">
      <div class="informacion-contacto">
        <ul>
          <li>Av. Principal 123</li>
          <li>Sucursal Centro</li>
          <li>Sucursal Norte</li>
          <li>(123) 456-7890</li>
        </ul>
      </div>
      <div class="social-correo">
        <ul>
          <li>Facebook</li>
          <li>info@lacteosdonjoaquin.com</li>
          <li>Instagram</li>
          <li>X Twitter</li>
        </ul>
      </div>
    </div>
    <div class="logo-container">
      <img id="logo" src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo">
    </div>
    <nav aria-label="Navegación principal">
      <ul>
        <li><a href="<?php echo $page_data['base_url']; ?>/" class="<?php echo $page_data['current_page'] === 'home' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productos-y-pedidos" class="<?php echo $page_data['current_page'] === 'productos-y-pedidos' ? 'active' : ''; ?>">Productos y Pedidos</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productores" class="<?php echo $page_data['current_page'] === 'productores' ? 'active' : ''; ?>">Productores</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/blog" class="<?php echo $page_data['current_page'] === 'blog' ? 'active' : ''; ?>">Blog y Recetas</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/acerca-de-nosotros" class="<?php echo $page_data['current_page'] === 'acerca-de-nosotros' ? 'active' : ''; ?>">Acerca de Nosotros</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- ALERTAS DE PRODUCTORES SIN ENTREGA -->
<?php if (!empty($notificaciones)): ?>
    <section class="alerta-pendiente" role="alert" aria-live="assertive">
        <strong>¡Atención! Productores sin entrega reciente</strong>
        <?php echo implode("<br>", $notificaciones); ?>
    </section>
<?php endif; ?>

    <!-- CARRUSEL DE PRODUCTORES -->
    <section class="seccion-productores">
      <h2 class="titulo-productores">Nuestros Productores</h2>

      <?php if (empty($productores)): ?>
        <p style="text-align:center; padding:60px; font-size:1.3rem; color:#666;">
          No hay productores registrados aún.
        </p>
      <?php else: ?>
        <div class="carrusel-productores-final">
          <button class="flecha-final flecha-izq" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
          <button class="flecha-final flecha-der" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>

          <div class="carrusel-final">
            <div class="track-final">
              <?php foreach ($productores as $p): ?>
                <div class="slide-final">
                  <div class="contenido-final">
                    <div class="datos-final">
                      <h3><?php echo htmlspecialchars($p['finca'] ?: $p['nombre']); ?></h3>
                      <p><strong>Productor:</strong> <?php echo htmlspecialchars($p['nombre']); ?></p>
                      <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($p['ubicacion'] ?: 'Chiriquí'); ?></p>
                      <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($p['especialidad'] ?: 'Leche fresca'); ?></p>
                      <p><strong>Producción diaria:</strong> <?php echo htmlspecialchars($p['produccion'] ?: 'No registrada'); ?> L</p>
                      <p><strong>Última entrega:</strong>
                        <span style="color: <?php echo (strtotime($p['ultima_entrega']) < strtotime('-3 days') || $p['ultima_entrega'] == 'Nunca') ? '#c62828' : '#2e7d32'; ?>">
                          <?php echo $p['ultima_entrega'] == 'Nunca' ? 'Nunca' : date('d/m/Y', strtotime($p['ultima_entrega'])); ?>
                        </span>
                      </p>
                    </div>
                    <div class="imagen-final">
                      <?php
                      $foto = $p['foto'] ?? 'default.jpg';
                      $ruta_foto = $page_data['assets_path'] . '/images/productores/' . $foto;
                      ?>
                      <img src="<?php echo $ruta_foto; ?>"
                        alt="<?php echo htmlspecialchars($p['nombre']); ?>"
                        onerror="this.src='<?php echo $page_data['assets_path']; ?>/images/productores/default.jpg'">
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Botón para registrar entrega -->
      <div style="text-align:center; margin:50px 0;">
        <button class="btn-registrar-entrega" style="font-size:1.2rem; padding:15px 40px;">
          Registrar Nueva Entrega de Leche
        </button>
      </div>
    </section>

    <!-- MODAL DE REGISTRO -->
    <div id="modalEntrega" class="modal">
      <div class="modal-contenido">
        <span class="cerrar">×</span>
        <h2>Registrar Entrega de Leche</h2>
        <form method="POST" class="form-entrega">
          <label>Productor</label>
          <select name="id_usuario_productor" required>
            <option value="">Seleccione...</option>
            <?php
            $sql = "SELECT up.id, p.nombre, p.finca FROM usuarios_productor up JOIN productores p ON up.id_productor = p.id ORDER BY p.nombre";
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
              echo "<option value='{$row['id']}'>" . htmlspecialchars($row['nombre']) . " - " . htmlspecialchars($row['finca']) . "</option>";
            }
            ?>
          </select>

          <label>Litros entregados</label>
          <input type="number" step="0.01" name="litros" placeholder="152.50" required>

          <label>Calidad</label>
          <select name="calidad" required>
            <option>Excelente</option>
            <option>Óptima</option>
            <option>Buena</option>
            <option>Regular</option>
          </select>

          <label>Fecha</label>
          <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>

          <button type="submit" name="registrar_entrega">Guardar Entrega</button>
        </form>
      </div>
    </div>

    <!-- Sección ¿Eres Productor? -->
    <section class="seccion-eres-productor" aria-labelledby="titulo-eres-productor">
      <h2 id="titulo-eres-productor" class="titulo-eres-productor">
        <span class="icono-botella-izq"></span>
        ¿Eres Productor?
        <span class="icono-botella-der"></span>
      </h2>

      <div class="contenido-eres-productor">
        <!-- Columna Izquierda -->
        <div class="info-beneficios">
          <button class="btn-conoce-beneficios">Conoce los Beneficios</button>

          <div class="textos-incentivo">
            <p class="texto-principal">Únete a nuestra red de productores</p>
            <p class="texto-secundario">Forma parte de una empresa comprometida con la calidad y el desarrollo sostenible de Panamá.</p>
          </div>

          <div class="lista-beneficios">
            <h3>Lista de Beneficios</h3>
            <ul>
              <li>Pago puntual y transparente</li>
              <li>Asesoría veterinaria gratuita</li>
              <li>Capacitación continua en buenas prácticas</li>
              <li>Acceso a tecnología de ordeño moderna</li>
              <li>Seguro para tu ganado</li>
            </ul>
          </div>

          <!-- BOTONES JUNTOS EN LA PARTE INFERIOR -->
          <div class="botones-accion">
            <button class="btn-postulate">Postúlate Aquí</button>
            <button class="btn-zona-productores">Zona de Productores</button>
          </div>
        </div>

        <!-- Columna Derecha - Solo imagen -->
        <div class="imagen-eres-productor">
          <img src="<?php echo $page_data['assets_path']; ?>/images/vaca.jpg" alt="Productores en la finca">
        </div>
      </div>
    </section>

    <!-- Sección de Nuestras Rutas -->
    <section class="seccion-nuestras-rutas" aria-labelledby="titulo-rutas">
      <h2 id="titulo-rutas" class="titulo-seccion-rutas">Nuestras Rutas</h2>

      <div class="contenedor-rutas">
        <!-- Panel lateral -->
        <aside class="panel-rutas">
          <button class="header-panel">
            <span class="texto-header">Nuestras Rutas</span>
            <span class="icono-flecha">▼</span>
          </button>

          <!-- AQUÍ ESTÁ EL TRUCO: todo envuelto en un div con fondo -->
          <div class="contenido-panel completo-fondo">
            <div class="dropdown-ruta">
              <button class="btn-dropdown activo">
                <span>Ruta Este - Sur</span>
                <span class="icono-dropdown">▼</span>
              </button>
              <div class="lista-items-ruta">
                <div class="item-ruta" data-ruta="ruta1">Ruta Norte - Centro</div>
                <div class="item-ruta activo" data-ruta="ruta2">Ruta Este - Sur</div> <!-- activo -->
                <div class="item-ruta" data-ruta="ruta3">Ruta Oeste - Rural</div>
                <div class="item-ruta" data-ruta="ruta4">Ruta Express City</div>
              </div>
            </div>
            <div class="contador-rutas">
              <strong>4 rutas activas</strong> recorriendo Chiriquí
            </div>
          </div>
        </aside>

        <!-- Información de ruta seleccionada -->
        <div class="info-ruta-seleccionada">
          <h3>Ruta Norte - Centro</h3>
          <p>Cubre las zonas norte de David y alrededores. Entregas diarias de 5:00 a.m. a 11:00 a.m.</p>
          <ul>
            <li>Frecuencia: Diaria</li>
            <li>Vehículos: 3 camiones refrigerados</li>
            <li>Productores: 12 fincas asociadas</li>
          </ul>
        </div>

        <!-- Mapa estático -->
        <div class="contenedor-mapa">
          <img src="<?php echo $page_data['assets_path']; ?>/images/mapa_david.jpg"
            alt="Mapa de rutas en Chiriquí"
            id="mapa-ruta"
            style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
        </div>
      </div>
    </section>

    <!-- Sección Nuestro Compromiso -->
    <section class="seccion-compromiso" aria-labelledby="titulo-compromiso">
      <h2 id="titulo-compromiso" class="titulo-compromiso">Nuestro Compromiso</h2>

      <div class="compromisos-grid">
        <!-- Compromiso 1 -->
        <div class="compromiso-card">
          <div class="imagen-compromiso">
            <img src="<?php echo $page_data['assets_path']; ?>/images/productos.jpg" alt="Botella de leche fresca con desayuno saludable">
          </div>
          <h3>Calidad Garantizada</h3>
          <p>Implementamos un sistema de gestión integral que asegura la trazabilidad desde la finca hasta el consumidor, priorizando la frescura y pureza de nuestra leche.</p>
        </div>

        <!-- Compromiso 2 -->
        <div class="compromiso-card">
          <div class="imagen-compromiso">
            <img src="<?php echo $page_data['assets_path']; ?>/images/productor5.jpg" alt="Vaca en pastos ecológicos">
          </div>
          <h3>Sostenibilidad Ambiental</h3>
          <p>Nuestro proceso de compra apoya prácticas ecológicas en las fincas, promoviendo el bienestar animal y reduciendo el impacto ambiental en la producción lechera.</p>
        </div>

        <!-- Compromiso 3 -->
        <div class="compromiso-card">
          <div class="imagen-compromiso">
            <img src="<?php echo $page_data['assets_path']; ?>/images/tecnologiaL.jpg" alt="Cartón de leche con sello de calidad">
          </div>
          <h3>Apoyo a la Comunidad</h3>
          <p>Facilitamos un sistema de compra justo y eficiente que beneficia directamente a nuestros productores locales, fomentando el crecimiento económico sostenible.</p>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
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

<script src="<?php echo $page_data['assets_path']; ?>/js/NProductores.js"></script>
<script defer src="<?php echo $page_data['assets_path']; ?>/js/entregaModal.js"></script>  <!-- defer asegura que cargue después del HTML -->
<script src="<?php echo $page_data['assets_path']; ?>/js/rutas.js"></script>
<script>
  // Notificaciones 
  <?php if (!empty($notificaciones)): ?>
    setTimeout(() => {
      alert("NOTIFICACIONES IMPORTANTES:\n\n" + "<?php echo implode("\n", $notificaciones); ?>");
    }, 1500);
  <?php endif; ?>
</script>

</body>

</html>
<?php $conn->close(); ?>```