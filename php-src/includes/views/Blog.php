<?php
// Cargar configuración de la página
require_once INCLUDES_PATH . '/includes/conexion.php';

$tipos = $conn->query("SELECT * FROM tipos_posts ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);

$posts = [];
foreach ($tipos as $tipo) {
    $sql = "SELECT p.*, t.nombre AS tipo_nombre 
            FROM posts p 
            JOIN tipos_posts t ON p.tipo_id = t.id 
            WHERE t.id = ? 
            ORDER BY p.fecha_creacion DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tipo['id']);
    $stmt->execute();
    $posts[$tipo['nombre']] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Lácteos Don Joaquín - Blog y Recetas">
  <title>Lácteos Don Joaquín - Blog y Recetas</title>

  <link rel="stylesheet" href="<?= $page_data['assets_path'] ?>/css/reseteo.css">
  <link rel="stylesheet" href="<?= $page_data['assets_path'] ?>/css/styles.css">
  <link rel="stylesheet" href="<?= $page_data['assets_path'] ?>/css/Blogcss.css">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="top-bar"></div>
    <div id="barra-principal">
      <ul class="informacion-contacto">
        <li>Av. Principal 123</li>
        <li>Sucursal Centro</li>
        <li>Sucursal Norte</li>
        <li>(123) 456-7890</li>
      </ul>
      <ul class="social-correo">
        <li>Facebook</li>
        <li>info@lacteosdonjoaquin.com</li>
        <li>Instagram</li>
        <li>X (Twitter)</li>
      </ul>
    </div>

    <div class="logo-container">
      <img id="logo" src="<?= $page_data['assets_path'] ?>/images/LogoBlanco.png" alt="Logo" width="90" height="90">
    </div>

    <nav aria-label="Navegación principal">
      <ul>
        <li><a href="<?= $page_data['base_url'] ?>/" class="<?= $page_data['current_page'] === 'home' ? 'active' : '' ?>">Home</a></li>
        <li><a href="<?= $page_data['base_url'] ?>/productos-y-pedidos" class="<?= $page_data['current_page'] === 'productos-y-pedidos' ? 'active' : '' ?>">Productos y Pedidos</a></li>
        <li><a href="<?= $page_data['base_url'] ?>/productores" class="<?= $page_data['current_page'] === 'productores' ? 'active' : '' ?>">Productores</a></li>
        <li><a href="<?= $page_data['base_url'] ?>/blog" class="active">Blog y Recetas</a></li>
        <li><a href="<?= $page_data['base_url'] ?>/acerca-de-nosotros" class="<?= $page_data['current_page'] === 'acerca-de-nosotros' ? 'active' : '' ?>">Acerca de Nosotros</a></li>
      </ul>
    </nav>

    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
      <h1 id="titulo-bienvenida">Descubre historias, consejos y sabores directamente de nuestra tierra.</h1>
    </section>
  </header>


  <!-- CARRUSEL DE CATEGORÍAS -->
  <div class="sticky-carousel">
    <div class="carousel-container">
      <button class="arrow left">&lt;</button>
      <div class="categories" id="categories">
        <button class="category-btn active" data-filter="all">Todas</button>
        <?php foreach ($tipos as $tipo): ?>
          <button class="category-btn" data-filter="<?= strtolower(htmlspecialchars($tipo['nombre'])) ?>">
            <?= htmlspecialchars($tipo['nombre']) ?>
          </button>
        <?php endforeach; ?>
      </div>
      <button class="arrow right">&gt;</button>
      <input type="search" id="search-input" placeholder="Buscar...">
    </div>
  </div>


  <main>
    <section class="posts-grid">
      <?php foreach ($posts as $tipo => $lista): ?>
        <?php foreach ($lista as $post): ?>
          <article class="card" data-type="<?= strtolower(htmlspecialchars($tipo)) ?>">
            <span class="label <?= strtolower(htmlspecialchars($tipo)) ?>"><?= htmlspecialchars($tipo) ?></span>
            <div class="img-placeholder">
              <img src="<?= htmlspecialchars($post['imagen']) ?>" 
                   alt="<?= htmlspecialchars($post['titulo']) ?>"
                   onerror="this.src='<?= $page_data['assets_path'] ?>/images/blog/placeholder.jpg'">
            </div>
            <h3><?= htmlspecialchars($post['titulo']) ?></h3>
            <p><?= htmlspecialchars(substr(strip_tags($post['contenido']), 0, 120)) ?>...</p>
          </article>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </section>

    <div class="pagination" id="pagination">
      <button id="prev-page">&lt;</button>
      <div id="page-numbers"></div>
      <button id="next-page">&gt;</button>
    </div>
  </main>


  <!-- FOOTER -->
  <footer class="footer">
    <div class="logo">
      <img src="<?= $page_data['assets_path'] ?>/images/LogoBlanco.png" alt="Logo" width="150" height="80">
    </div>
    <div class="social">
      <a href="#" aria-label="Instagram">Instagram</a>
      <a href="#" aria-label="Facebook">Facebook</a>
      <a href="#" aria-label="WhatsApp">WhatsApp</a>
      <a href="mailto:info@lacteosdonjoaquin.com">Email</a>
    </div>
    <div class="derechos">
      <p>&copy; <?= $page_data['current_year'] ?> Lácteos Don Joaquín. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="<?= $page_data['assets_path'] ?>/js/Blogjs.js"></script>
</body>
</html>