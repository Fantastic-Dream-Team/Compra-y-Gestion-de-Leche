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

    <!-- Sección de etapas de control de calidad -->
    <section class="etapas-control-calidad" aria-labelledby="titulo-calidad">
      <h2 id="titulo-calidad" class="titulo-carrusel">Gestionamos la Calidad en Cada Etapa</h2>
      <div class="carrusel-container">
        <button class="flecha flecha-izq" aria-label="Diapositiva anterior">&#10094;</button>
        
        <div class="carrusel-slide">
          <div class="carrusel-img">
            <img src="<?php echo $page_data['assets_path']; ?>/images/Controles-Calidad-Lacteos-Don-Joaquin.jpg" alt="Análisis de Calidad en laboratorio" width="600" height="400">
          </div>
          <div class="carrusel-description">
            <h3 class="subtitulo">Permanentes Controles de calidad</h3>
            <p>
              El primer análisis ocurre en laboratorio y sucede antes de la manipulación de la materia prima. 
              Una vez aprueba el primer filtro, se procesa en la fábrica, con rigurosos controles de higiene. 
              Personal técnico vigila que se cumplan las temperaturas ideales durante toda la preparación de nuestros productos. 
              Un tercer análisis sucede, previo a su distribución, para garantizar que cumplen con altos estándares de calidad.
            </p>
          </div>
        </div>

        <button class="flecha flecha-der" aria-label="Diapositiva siguiente">&#10095;</button>
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
                  <img src="<?php echo $page_data['assets_path']; ?>/images/proyectovacasjersey.png" alt="Proyecto Vacas Jersey - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/proyectovacasjersey.png" alt="Proyecto Vacas Jersey - Imagen 3">
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
            <a href="vacasJersey.html" class="ver-mas">VER MÁS</a>
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
                  <img src="<?php echo $page_data['assets_path']; ?>/images/laboratorioordeño.jpg" alt="Laboratorio de Ordeño - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/laboratorioordeño.jpg" alt="Laboratorio de Ordeño - Imagen 3">
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
            <h3>Laboratorio de Ordeño</h3>
            <a href="laboratorio-ordeño.html" class="ver-mas">VER MÁS</a>
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
                  <img src="<?php echo $page_data['assets_path']; ?>/images/procesoordeño.png" alt="Proceso de Ordeño - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/procesoordeño.png" alt="Proceso de Ordeño - Imagen 3">
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
            <a href="proceso-ordeño.html" class="ver-mas">VER MÁS</a>
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
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productos.jpg" alt="Productos Lácteos - Imagen 1">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productos.jpg" alt="Productos Lácteos - Imagen 2">
                </div>
                <div class="carrusel-slide">
                  <img src="<?php echo $page_data['assets_path']; ?>/images/productos.jpg" alt="Productos Lácteos - Imagen 3">
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
            <a href="productos.html" class="ver-mas">VER MÁS</a>
          </div>
        </article>
      </div>
    </section>

    <!-- Sección de blog y eventos -->
    <section class="seccion blog-y-eventos" aria-labelledby="titulo-blog">
      <div class="franja-naranja">
        <h2 id="titulo-blog" class="titulo">Blog y Eventos</h2>
      </div>

      <div class="carrusel-blog">
        <button class="flecha flecha-izq" aria-label="Publicaciones anteriores">&#10094;</button>

        <div class="blog">
          <article class="post post1">
            <span class="fecha">15/08/2025</span>
            <h3 class="subtitulo">Control de Calidad: Nuevos estándares implementados para garantizar la excelencia en todos nuestros productos</h3>
          </article>

          <article class="post post2">
            <span class="fecha">06/09/2025</span>
            <h3 class="subtitulo">Ganadería Sostenible: Innovaciones en el cuidado y manejo responsable del ganado bovino</h3>
          </article>

          <article class="post post3">
            <span class="fecha">15/09/2025</span>
            <h3 class="subtitulo">Tecnología GLEP: Revolucionando los procesos industriales con soluciones inteligentes</h3>
          </article>
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