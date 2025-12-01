<?php
require_once INCLUDES_PATH . '/config.php';

$tipos = $conn->query("SELECT * FROM tipos_posts ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);

$posts = [];
foreach ($tipos as $tipo) {
    $sql = "SELECT p.*, t.nombre as tipo_nombre 
            FROM posts p 
            JOIN tipos_posts t ON p.tipo_id = t.id 
            WHERE t.id = ? 
            ORDER BY p.fecha_creacion DESC";
    $stmt = query($sql, [$tipo['id']]);
    $posts[$tipo['nombre']] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Lácteos Don Joaquín - Productos lácteos de la más alta calidad, elaborados con amor y dedicación">
  <link rel="stylesheet" href="css/Blogcss.css">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <title>Lácteos Don Joaquín - Blog</title>
</head>
<body>
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
      <img id="logo" src="assets/images/LogoBlanco.png" alt="Logo de Lácteos Don Joaquín" width="90" height="90">
    </div>

  <nav aria-label="Navegación principal">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="productos.html">Productos</a></li>
        <li><a href="productores.html">Productores</a></li>
        <li><a href="blog.html" class="active">Blog y Recetas</a></li>
        <li><a href="acercaDeNosotros.html">Acerca de Nosotros</a></li>
      </ul>
    </nav>

    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
      <h1 id="titulo-bienvenida">Descubre historias, consejos y sabores directamente de nuestra tierra.</h1>
    </section>
  </header>


  <div class="sticky-carousel">
    <div class="carousel-container">
      <button class="arrow left">&lt;</button>
      <div class="categories" id="categories">
        <button class="category-btn active" data-filter="all">Todas</button>
        <?php foreach ($tipos as $tipo): ?>
          <button class="category-btn" data-filter="<?= strtolower($tipo['nombre']) ?>">
            <?= $tipo['nombre'] ?>
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
          <article class="card" data-type="<?= strtolower($tipo) ?>">
            <span class="label <?= strtolower($tipo) ?>"><?= $tipo ?></span>
            <div class="img-placeholder">
              <img src="<?= htmlspecialchars($post['imagen']) ?>" alt="<?= htmlspecialchars($post['titulo']) ?>">
            </div>
            <h3><?= htmlspecialchars($post['titulo']) ?></h3>
            <p><?= htmlspecialchars(substr($post['contenido'], 0, 120)) ?>...</p>
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

  <!-- footer igual -->
  <script src="js/Blogjs.js"></script>
</body>
</html>