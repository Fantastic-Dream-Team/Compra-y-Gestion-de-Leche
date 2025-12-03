<?php
// Datos para la vista productos
$page_data = [
    'page_title' => 'Lácteos Don Joaquín - Productos',
    'current_page' => 'productos',
    'assets_path' => ASSETS_PATH,
    'base_url' => dirname($_SERVER['SCRIPT_NAME']),
    'current_year' => date('Y')
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Lácteos Don Joaquín - Productos lácteos de la más alta calidad, elaborados con amor y dedicación">
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/Productos.css">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <title><?php echo $page_data['page_title']; ?></title>
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
      <img id="logo" src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo de Lácteos Don Joaquín" width="90" height="90">
    </div>

    <nav aria-label="Navegación principal">
      <ul>
        <li><a href="<?php echo $page_data['base_url']; ?>/">Home</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productos" class="active">Productos</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/productores">Productores</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/blog">Blog y Recetas</a></li>
        <li><a href="<?php echo $page_data['base_url']; ?>/acerca-de-nosotros">Acerca de Nosotros</a></li>
      </ul>
    </nav>

    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
      <h1 id="titulo-bienvenida">Nuestros productos, Nuestra pasión</h1>
    </section>
  </header>

  <!-- BARRA STICKY + BUSCADOR (se queda arriba al hacer scroll) -->
    <div class="sticky-carousel">
      <div class="carousel-container">
        <button class="arrow left" aria-label="Izquierda">&lt;</button>

        <div class="categories" id="categories">
          <button class="category-btn active" data-filter="all">Todas</button>
          <button class="category-btn" data-filter="quesos">Quesos</button>
          <button class="category-btn" data-filter="yogurts">Yogurts</button>
          <button class="category-btn" data-filter="mousse">Mousse</button>
        </div>

        <button class="arrow right" aria-label="Derecha">&gt;</button>

        <input type="search" id="search-input" placeholder="Buscar producto..." aria-label="Buscar producto">
      </div>
    </div>

  <main class="productos-main">

    <!-- QUESOS -->
    <section class="categoria" data-type="quesos">
      <h2 class="titulo-categoria">Quesos</h2>
      <div class="carrusel">
        <button class="flecha izquierda"><</button>
        <div class="contenedor-productos">
          <div class="producto" id="brie-artesanal">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/queso-brie.jpg" alt="Brie Artesanal">
            <div class="caja-titulo">Brie Artesanal</div>
            <p>Queso blando de corteza florida, cremoso y con delicado sabor a nuez.</p>
          </div>
          <div class="producto" id="camembert-tradicional">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/queso-camembert.jpg" alt="Camembert">
            <div class="caja-titulo">Camembert Tradicional</div>
            <p>Textura cremosa y aroma intenso. Perfecto para derretir o disfrutar solo.</p>
          </div>
          <div class="producto" id="queso-fresco-de-vaca">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/queso-fresco.jpg" alt="Queso Fresco">
            <div class="caja-titulo">Queso Fresco de Vaca</div>
            <p>Suave, ligeramente salado. Ideal para ensaladas, tacos y postres.</p>
          </div>
          <div class="producto" id="gouda-ahumado">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/queso-gouda.jpg" alt="Gouda Ahumado">
            <div class="caja-titulo">Gouda Ahumado</div>
            <p>Curado y ahumado naturalmente con madera de encino. Sabor profundo.</p>
          </div>
        </div>
        <button class="flecha derecha">></button>
      </div>
    </section>

    <!-- YOGURTS -->
    <section class="categoria" data-type="yogurts">
      <h2 class="titulo-categoria">Yogurts</h2>
      <div class="carrusel">
        <button class="flecha izquierda"><</button>
        <div class="contenedor-productos">
          <div class="producto" id="yogur-con-fresa">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/yogur-fresa.jpg" alt="Yogur con Fresa">
            <div class="caja-titulo">Yogur con Fresa</div>
            <p>Yogur cremoso batido con trozos de fresa fresca natural.</p>
          </div>
          <div class="producto" id="yogur-griego-frutos-rojos">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/yogur-frutosrojos.jpg" alt="Yogur Griego Frutos Rojos">
            <div class="caja-titulo">Yogur Griego Frutos Rojos</div>
            <p>Extra espeso con mermelada casera de frutos del bosque.</p>
          </div>
          <div class="producto" id="yogur-natural-entero">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/yogur-natural.jpg" alt="Yogur Natural">
            <div class="caja-titulo">Yogur Natural Entero</div>
            <p>100% natural, sin azúcar añadida. Ideal para desayunos saludables.</p>
          </div>
          <div class="producto" id="yogur-cremoso-vainilla">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/yogur-vainilla.jpg" alt="Yogur Vainilla">
            <div class="caja-titulo">Yogur Cremoso Vainilla</div>
            <p>Sabor suave a vainilla bourbon. Perfecto como postre ligero.</p>
          </div>
        </div>
        <button class="flecha derecha">></button>
      </div>
    </section>

    <!-- MOUSSE -->
    <section class="categoria" data-type="mousse">
      <h2 class="titulo-categoria">Mousse</h2>
      <div class="carrusel">
        <button class="flecha izquierda"><</button>
        <div class="contenedor-productos">
          <div class="producto" id="mousse-de-fresa">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/mousse-fresa.jpg" alt="Mousse de Fresa">
            <div class="caja-titulo">Mousse de Fresa</div>
            <p>Delicado mousse de yogur natural con fresas frescas y miel.</p>
          </div>
          <div class="producto" id="mousse-de-vainilla">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/mousse-vainilla.jpg" alt="Mousse de Vainilla">
            <div class="caja-titulo">Mousse de Vainilla</div>
            <p>Crema suave de vainilla con caramelo artesanal por encima.</p>
          </div>
          <div class="producto" id="mousse-de-mora-azul">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/mousse-mora.jpg" alt="Mousse de Mora Azul">
            <div class="caja-titulo">Mousse de Mora Azul</div>
            <p>Intenso sabor a mora silvestre. ¡Nuestro best-seller!</p>
          </div>
          <div class="producto" id="mousse-de-chocolate">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Productos/mousse-chocolate.jpg" alt="Mousse de Chocolate">
            <div class="caja-titulo">Mousse de Chocolate</div>
            <p>Chocolate amargo 70% con crema de leche fresca. Irresistible.</p>
          </div>
        </div>
        <button class="flecha derecha">></button>
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

  <script src="<?php echo $page_data['assets_path']; ?>/js/Productos.js"></script>
</body>
</html>