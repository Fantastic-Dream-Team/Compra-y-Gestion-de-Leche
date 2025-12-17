<?php
// Datos para la vista home
$page_data = [
    'page_title' => 'Lácteos Don Joaquín - Inicio',
    'current_page' => 'home',
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
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/reseteo.css">
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <title><?php echo $page_data['page_title']; ?></title>
</head>
<body>
  <header>
    <!-- Barra superior -->
    <div class="top-bar">
      <div class="ubicacion"></div>
      <div class="redes"></div>
    </div>

    <!-- Header con logo y menú -->
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
      <img id="logo" src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo de Lácteos Don Joaquín" width="100" height="100">
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

    <!-- Hero / Frase de bienvenida -->
    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
      <h1 id="titulo-bienvenida">Bienvenido a Lácteos Don Joaquín</h1>
      <p>En Lácteos Don Joaquín, nos apasiona ofrecer productos lácteos de la más alta calidad, elaborados con amor y dedicación.</p>
    </section>
  </header>

  <main>
    <!-- Sección de bienvenida -->
    <section class="seccion-bienvenida" aria-labelledby="titulo-razon">
      <div class="contenido-seccion">
        <div class="contenido-texto">
          <div class="titulo">
            <h2 id="titulo-razon">Nuestra Razón de Ser</h2>
          </div>
          <div class="parrafo">
            <p>
              En Lácteos Don Joaquín, nuestra misión es ofrecer productos lácteos de la más alta calidad, 
              elaborados con técnicas tradicionales y el máximo cuidado. Con más de 30 años de experiencia, 
              mantenemos el compromiso de llevar a su mesa el auténtico sabor de los lácteos artesanales, 
              respetando los procesos naturales y garantizando la frescura en cada uno de nuestros productos.
            </p>
          </div>
        </div>

        <div class="imagen-bienvenida">
          <img src="<?php echo $page_data['assets_path']; ?>/images/vacas.png" alt="Vacas en nuestro campo" width="500" height="300">
        </div>
      </div>
    </section>

  <section class="etapas-control-calidad">
  <h2 class="titulo-carrusel">Etapas de Control de Calidad</h2>

  <div class="carrusel-wrapper">
    <!-- Flecha izquierda -->
    <button class="flecha flecha-izq">&#10094;</button>

    <!-- Ventana del carrusel -->
    <div class="carrusel-viewport">
      <div class="carrusel-slides">

        <!-- SLIDE 1 -->
        <div class="carrusel-slide">
          <div class="carrusel-img">
<img src="<?php echo $page_data['assets_path']; ?>/images/Controles-Calidad-Lacteos-Don-Joaquin.jpg" alt="Proyecto Vacas Jersey - Imagen 1">          </div>
          <div class="carrusel-description">
            <h3 class="subtitulo">Recepción de la leche</h3>
            <p>Se verifica temperatura, olor y apariencia antes de iniciar el proceso de seleccion, 
              aqui es importante la calidad y tambien se determina la frescura de la leche.</p>
          </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="carrusel-slide">
          <div class="carrusel-img">
            <img src="<?php echo $page_data['assets_path']; ?>/images/vacas.jpg" alt="Control de calidad 2">
          </div>
          <div class="carrusel-description">
            <h3 class="subtitulo">Análisis de laboratorio</h3>
            <p>Pruebas microbiológicas y fisicoquímicas para asegurar pureza.</p>
          </div>
        </div>

        <!-- SLIDE 3 -->
        <div class="carrusel-slide">
          <div class="carrusel-img">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Controles-Calidad-Lacteos-Don-Joaquin.jpg" alt="Proyecto Vacas Jersey - Imagen 1">
          </div>
          <div class="carrusel-description">
            <h3 class="subtitulo">Proceso de pasteurización</h3>
            <p>Eliminación de bacterias mediante control térmico.</p>
          </div>
        </div>

        <!-- SLIDE 4 -->
        <div class="carrusel-slide">
          <div class="carrusel-img">
            <img src="assets/images/control4.jpg" alt="Control de calidad 4">
          </div>
          <div class="carrusel-description">
            <h3 class="subtitulo">Producto final</h3>
            <p>Verificación final antes del envasado y distribución.</p>
          </div>
        </div>

      </div>
    </div>

    <!-- Flecha derecha -->
    <button class="flecha flecha-der">&#10095;</button>
  </div>
</section>

    <section class="nuestro-entorno" aria-labelledby="titulo-entorno">
      <h2 id="titulo-entorno" class="titulo-seccion">Nuestro Entorno</h2>
 
      
      <div class="proyectos-grid">
        <!-- Proyecto 1: Vacas Jersey -->
        <article class="proyecto-card vacas-jersey">
          <div class="carrusel-contenedor">
            <div class="carrusel">
              <input type="radio" name="carrusel-vacas" id="vacas-1" checked>
              <input type="radio" name="carrusel-vacas" id="vacas-2">
              <input type="radio" name="carrusel-vacas" id="vacas-3">
              
              <div class="carrusel-slides">
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/proyectovacasjersey.png" alt="Proyecto Vacas Jersey - Imagen 1">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/vacas2.jpg" alt="Proyecto Vacas Jersey - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/vacas3.jpg" alt="Proyecto Vacas Jersey - Imagen 3">
                </div>
              </div>
              
              <div class="carrusel-controles">
                <label for="vacas-1" class="carrusel-punto"></label>
                <label for="vacas-2" class="carrusel-punto"></label>
                <label for="vacas-3" class="carrusel-punto"></label>
              </div>
            </div>
          </div>
            <div class="contenido-proyecto">
     <h3>Proyecto - Vacas Jersey</h3>
    <a href="https://aurocha.com/raza-jersey-descubre-la-excelencia/" target="_blank" class="ver-mas" 
       aria-label="Más información sobre Vacas Jersey">VER MÁS</a>
  </div>
</article>
        
        <!-- Proyecto 2: Laboratorio de Ordeño -->
        <article class="proyecto-card laboratorio-ordeño">
          <div class="carrusel-contenedor">
            <div class="carrusel">
              <input type="radio" name="carrusel-lab" id="lab-1" checked>
              <input type="radio" name="carrusel-lab" id="lab-2">
              <input type="radio" name="carrusel-lab" id="lab-3">
              
              <div class="carrusel-slides">
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/laboratorioordeño.jpg" alt="Laboratorio de Ordeño - Imagen 1">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/lab2.png" alt="Laboratorio de Ordeño - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/Controles-Calidad-Lacteos-Don-Joaquin.jpg" alt="Laboratorio de Ordeño - Imagen 3">
                </div>
              </div>
              
              <div class="carrusel-controles">
                <label for="lab-1" class="carrusel-punto"></label>
                <label for="lab-2" class="carrusel-punto"></label>
                <label for="lab-3" class="carrusel-punto"></label>
              </div>
            </div>
          </div>
          <div class="contenido-proyecto">
    <h3>Laboratorio de ordeñación</h3>
    <a href="https://lacteosdonjoaquin.com/nosotros/" 
       target="_blank" class="ver-mas" 
       aria-label="Más información sobre procesos de ordeño">VER MÁS</a>
  </div>
</article>

        <!-- Proyecto 3: Proceso de Ordeño -->
        <article class="proyecto-card proceso-ordeño">
          <div class="carrusel-contenedor">
            <div class="carrusel">
              <input type="radio" name="carrusel-proceso" id="proceso-1" checked>
              <input type="radio" name="carrusel-proceso" id="proceso-2">
              <input type="radio" name="carrusel-proceso" id="proceso-3">
              
              <div class="carrusel-slides">
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/procesoordeño.png" alt="Proceso de Ordeño - Imagen 1">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productor1.jpg" alt="Proceso de Ordeño - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/lab5.jpg" alt="Proceso de Ordeño - Imagen 3">
                </div>
              </div>
              
              <div class="carrusel-controles">
                <label for="proceso-1" class="carrusel-punto"></label>
                <label for="proceso-2" class="carrusel-punto"></label>
                <label for="proceso-3" class="carrusel-punto"></label>
              </div>
            </div>
          </div>
          <div class="contenido-proyecto">
            <h3>Proceso de Ordeño</h3>
      <a href="" 
       target="_blank" class="ver-mas" 
       aria-label="Más información sobre procesos de ordeño">VER MÁS</a>
  </div>
</article>
        
        <!-- Proyecto 4: Productos -->
        <article class="proyecto-card productos">
          <div class="carrusel-contenedor">
            <div class="carrusel">
              <input type="radio" name="carrusel-productos" id="productos-1" checked>
              <input type="radio" name="carrusel-productos" id="productos-2">
              <input type="radio" name="carrusel-productos" id="productos-3">
              
              <div class="carrusel-slides">
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?> /images/productos.jpg" alt="Productos Lácteos - Imagen 1">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productos/queso-gouda.jpg" alt="Productos Lácteos - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productos/queso-brie.jpg" alt="Productos Lácteos - Imagen 3">
                </div>
              </div>
              
              <div class="carrusel-controles">
                <label for="productos-1" class="carrusel-punto"></label>
                <label for="productos-2" class="carrusel-punto"></label>
                <label for="productos-3" class="carrusel-punto"></label>
              </div>
            </div>
          </div>
          <div class="contenido-proyecto">
            <h3>Productos</h3>
            <a href="<?php echo $page_data['base_url']; ?>/productos-y-pedidos" class="ver-mas"
       aria-label="Ver nuestros productos">VER MÁS</a>
  </div>
</div>
</article>


<!-- blog -->

   <section class="seccion blog-y-eventos" aria-labelledby="titulo-blog">
  <div class="franja-naranja">
    <h2 id="titulo-blog" class="titulo" style="color: white;">Blog y Eventos</h2>
  </div>

  <div class="carrusel-blog">
    <button class="flecha flecha-izq" aria-label="Publicaciones anteriores">&#10094;</button>

 <div class="blog">
  <?php
  // Consulta para obtener los últimos 10 posts ordenados por fecha (más reciente primero)
  $sql = "SELECT p.id, p.titulo, p.contenido, p.imagen, tp.nombre AS tipo, p.fecha_creacion 
          FROM posts p 
          JOIN tipos_posts tp ON p.tipo_id = tp.id 
          ORDER BY p.fecha_creacion DESC 
          LIMIT 10";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
      $fecha = date('d/m/Y', strtotime($post['fecha_creacion'] ?? 'now'));
      $label_class = strtolower($post['tipo']) === 'receta' ? 'receta' : 'blog';
      $label_text = $post['tipo'];
      ?>
      <a href="<?php echo $page_data['base_url']; ?>/blog" class="post-link" aria-label="Ver todos los posts en el blog">
        <article class="post">
          <span class="fecha"><?php echo $fecha; ?></span>
          <h3 class="subtitulo"><?php echo htmlspecialchars($post['titulo']); ?></h3>
          <span class="label <?php echo $label_class; ?>"><?php echo $label_text; ?></span>
        </article>
      </a>
      <?php
    }
  } else {
    // Fallback si no hay posts
    echo '<a href="' . $page_data['base_url'] . '/blog" class="post-link">
            <article class="post">
              <span class="fecha">15/12/2025</span>
              <h3 class="subtitulo">Bienvenidos al nuevo blog</h3>
            </article>
          </a>';
  }
  ?>
</div>
    <button class="flecha flecha-der" aria-label="Publicaciones siguientes">&#10095;</button>
  </div>

  <div class="franja-naranja"></div>
</section>

  </main>

  <!-- Footer -->
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
</body>
</html>