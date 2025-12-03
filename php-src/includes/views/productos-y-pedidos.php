<?php
global $conn;
require_once INCLUDES_PATH . '/conexion.php'; 

// ===== DATOS DE PÁGINA (FALTANTE) =====
$page_data = [
    'page_title' => 'Lácteos Don Joaquín - Productos',
    'current_page' => 'productos-y-pedidos',
    'assets_path' => ASSETS_PATH,
    'base_url' => dirname($_SERVER['SCRIPT_NAME']),
    'current_year' => date('Y')
];

// Obtener categorías
$categorias = $conn->query("SELECT * FROM categorias_productos ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);

$productosPorCategoria = [];
foreach ($categorias as $cat) {
    $id = $cat['id'];
    $sql = "SELECT * FROM productos WHERE categoria_id = ? ORDER BY nombre";
    $stmt = query($sql, [$id]);
    $productosPorCategoria[$cat['nombre']] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_data['page_title']; ?></title>
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/reseteo.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styles.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/Productos.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="top-bar"></div>

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
                <li>X (Twitter)</li>
            </ul>
        </div>
    </div>

    <div class="logo-container">
        <img id="logo" src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo de Lácteos Don Joaquín" width="90" height="90">
    </div>

    <nav aria-label="Navegación principal">
      <ul>
        <li><a href="<?php echo $page_data['base_url']; ?>/" class="<?php echo $page_data['current_page'] === 'home' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productos-y-pedidos" class="<?php echo $page_data['current_page'] === 'productos-y-pedidos' ? 'active' : ''; ?>">Productos</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productores" class="<?php echo $page_data['current_page'] === 'productores' ? 'active' : ''; ?>">Productores</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/blog" class="<?php echo $page_data['current_page'] === 'blog' ? 'active' : ''; ?>">Blog y Recetas</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/acerca-de-nosotros" class="<?php echo $page_data['current_page'] === 'acerca-de-nosotros' ? 'active' : ''; ?>">Acerca de Nosotros</a></li>
      </ul>
    </nav>

    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
        <h1 id="titulo-bienvenida">Nuestros Productos de Calidad</h1>
        <p>Descubre la variedad de productos lácteos frescos y naturales elaborados con dedicación y tradición.</p>
    </section>
</header>

<!-- BARRA STICKY -->
<div class="sticky-bar">
    <div class="carousel-container">
        <button class="arrow left">&lt;</button>
        <div class="categories" id="categories">
            <button class="category-btn active" data-filter="all">Todas</button>
            <?php foreach ($categorias as $cat): ?>
                <button class="category-btn" data-filter="<?= strtolower($cat['nombre']) ?>">
                    <?= htmlspecialchars($cat['nombre']) ?>
                </button>
            <?php endforeach; ?>
        </div>
        <button class="arrow right">&gt;</button>
        <input type="search" id="search-input" placeholder="Buscar producto...">
    </div>
</div>

<main class="productos-main">
    <?php foreach ($categorias as $cat): ?>
        <section class="categoria" data-type="<?= strtolower($cat['nombre']) ?>">
            <h2 class="titulo-categoria"><?= htmlspecialchars($cat['nombre']) ?></h2>
            <div class="carrusel">
                <button class="flecha izquierda"><</button>
                <div class="contenedor-productos">
                    <?php foreach ($productosPorCategoria[$cat['nombre']] as $prod):
                        $id_slug = strtolower(str_replace(' ', '-', $prod['nombre']));
                        ?>
                        <div class="producto" id="<?= $id_slug ?>">
                            <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>">
                            <div class="caja-titulo"><?= htmlspecialchars($prod['nombre']) ?></div>
                            <p><?= htmlspecialchars($prod['descripcion']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="flecha derecha">></button>
            </div>
        </section>
    <?php endforeach; ?>
</main>

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

<script src="<?php echo $page_data['assets_path']; ?>/js/Productos.js"></script>
</body>
</html>