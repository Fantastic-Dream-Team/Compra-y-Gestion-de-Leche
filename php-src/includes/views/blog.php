<?php
// Datos para la vista blog
$page_data = [
    'page_title' => 'Lácteos Don Joaquín - Blog',
    'current_page' => 'blog',
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
  <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/Blogcss.css">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <title><?php echo $page_data['page_title']; ?></title>
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
    <li><a href="<?php echo $page_data['base_url']; ?>/productos-y-pedidos" class="<?php echo $page_data['current_page'] === 'productos-y-pedidos' ? 'active' : ''; ?>">Productos y Pedidos</a></li>
    <li><a href="<?php echo $page_data['base_url']; ?>/productores" class="<?php echo $page_data['current_page'] === 'productores' ? 'active' : ''; ?>">Productores</a></li>
    <li><a href="<?php echo $page_data['base_url']; ?>/blog" class="<?php echo $page_data['current_page'] === 'blog' ? 'active' : ''; ?>">Blog y Recetas</a></li>
    <li><a href="<?php echo $page_data['base_url']; ?>/acerca-de-nosotros" class="<?php echo $page_data['current_page'] === 'acerca-de-nosotros' ? 'active' : ''; ?>">Acerca de Nosotros</a></li>
      </ul>
    </nav>

    <section class="bienvenida" aria-labelledby="titulo-bienvenida">
      <h1 id="titulo-bienvenida">Descubre historias, consejos y sabores directamente de nuestra tierra.</h1>
    </section>
  </header>

  <main>
    <!-- Carrusel sticky de filtros -->
    <div class="sticky-carousel">
      <div class="carousel-container">
        <button class="arrow left" aria-label="Desplazar categorías a la izquierda">&lt;</button>

        <div class="categories" id="categories">
          <button class="category-btn active" data-filter="all">Todas</button>
          <button class="category-btn" data-filter="receta">Recetas</button>
          <button class="category-btn" data-filter="blog">Blogs</button>
        </div>

        <button class="arrow right" aria-label="Desplazar categorías a la derecha">&gt;</button>

        <input type="search" id="search-input" placeholder="Buscar..." aria-label="Buscar en blog">
      </div>
    </div>

    <!-- Grid de publicaciones -->
    <section class="blog-posts">
      <div class="grid" id="post-grid">
        <!-- 12 posts originales + 12 nuevos = 24 -->
        <!-- Posts originales -->
        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/flan-casero.jpg" alt="Flan Casero con Leche Fresca"></div>
          <h3>Flan Casero con Leche Fresca</h3>
          <p>Un postre tradicional con nuestra leche entera. Suave, cremoso y fácil de preparar en casa.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/beneficios-leche-fresca.jpg" alt="Leche fresca de pastoreo"></div>
          <h3>Beneficios de la Leche Fresca</h3>
          <p>Conoce por qué la leche de vacas alimentadas con pasto es más nutritiva y sabrosa.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/queso-casero-facil.jpg" alt="Queso casero fresco"></div>
          <h3>Queso Casero Fácil</h3>
          <p>Aprende a hacer un queso fresco en casa con pocos ingredientes y mucho sabor.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/como-elegir-productos-lacteos.jpg" alt="Leer etiquetas de lácteos"></div>
          <h3>Cómo Elegir Productos Lácteos</h3>
          <p>Consejos para leer etiquetas y escoger leche, yogur y queso de calidad.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/batido-yogur-frutas.jpg" alt="Batido de yogur y frutas"></div>
          <h3>Batido Energético de Yogur y Frutas</h3>
          <p>Un batido nutritivo para comenzir el día con energía usando nuestro yogur natural.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/historias-lecheria.jpg" alt="Historia de la lechería"></div>
          <h3>Historias de Nuestra Lechería</h3>
          <p>Conoce la historia familiar detrás de Lácteos Don Joaquín y nuestras prácticas sostenibles.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/mousse-queso-limon.jpg" alt="Mousse de queso y limón"></div>
          <h3>Mousse de Queso y Limón</h3>
          <p>Postre ligero y cítrico elaborado con queso crema artesanal.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/importancia-pasto-natural.jpg" alt="Pasto natural para ganado"></div>
          <h3>La Importancia del Pasto Natural</h3>
          <p>Exploramos cómo la alimentación del ganado impacta la calidad de la leche.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/panqueques-leche.jpg" alt="Panqueques esponjosos"></div>
          <h3>Panqueques Esponjosos con Leche</h3>
          <p>Una receta clásica para el desayuno que usa leche fresca para mejorar textura y sabor.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/preguntas-frecuentes-lacteos.jpg" alt="Preguntas frecuentes lácteos"></div>
          <h3>Preguntas Frecuentes sobre Lácteos</h3>
          <p>Respondemos dudas comunes sobre conservación, caducidad y tipos de leche.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/crema-queso-untar.jpg" alt="Crema de queso para untar"></div>
          <h3>Crema de Queso para Untar</h3>
          <p>Prepara una crema de queso casera ideal para panes y snacks rápidos.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/leche-entera-descremada.jpg" alt="Leche entera y descremada"></div>
          <h3>¿Leche entera o descremada?</h3>
          <p>Te explicamos las diferencias y cuál es mejor según tus necesidades.</p>
        </article>

        <!-- 12 NUEVOS POSTS -->
        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/bechamel-leche.jpg" alt="Salsa bechamel cremosa"></div>
          <h3>Salsa Bechamel con Leche Don Joaquín</h3>
          <p>Una base cremosa perfecta para lasañas, gratinados y pastas. ¡Fácil y deliciosa!</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/yogur-superalimento.jpg" alt="Yogur natural y probióticos"></div>
          <h3>¿Por qué el yogur es un superalimento?</h3>
          <p>Probióticos, calcio y proteínas: todo lo que necesitas saber sobre el yogur natural.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/helado-vainilla-casero.jpg" alt="Helado de vainilla casero"></div>
          <h3>Helado de Vainilla Casero</h3>
          <p>Sin máquina, solo con leche, crema y vainilla. ¡Ideal para el verano!</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/pasteurizacion-proceso.jpg" alt="Proceso de pasteurización"></div>
          <h3>El proceso de pasteurización explicado</h3>
          <p>Cómo mantenemos la seguridad y el sabor en cada botella de leche.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/tostadas-francesas.jpg" alt="Tostadas francesas con canela"></div>
          <h3>Tostadas Francesas con Leche y Canela</h3>
          <p>Desayuno dulce y esponjoso que toda la familia amará.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/lacteos-mitos-verdades.jpg" alt="Mitos sobre lácteos"></div>
          <h3>¿Los lácteos engordan? Mitos y verdades</h3>
          <p>Desmontamos creencias populares con base científica.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/queso-panela-plancha.jpg" alt="Queso panela a la plancha"></div>
          <h3>Queso Panela a la Plancha</h3>
          <p>Snack saludable y crujiente en solo 5 minutos.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/vacas-nombres-personalidades.jpg" alt="Vacas de la lechería"></div>
          <h3>Nuestras vacas: nombres y personalidades</h3>
          <p>Conoce a las estrellas de nuestra lechería: ¡Lucero, Luna y más!</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/pudin-chia-yogur.jpg" alt="Pudín de chia con yogur"></div>
          <h3>Pudín de Chia con Yogur</h3>
          <p>Desayuno saludable, saciante y lleno de fibra.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/almacenar-lacteos.jpg" alt="Almacenamiento de lácteos"></div>
          <h3>Cómo almacenar correctamente tus lácteos</h3>
          <p>Consejos para mantener frescura y sabor por más tiempo.</p>
        </article>

        <article class="card" data-type="receta">
          <span class="label receta">Receta</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/sopa-queso-brocoli.jpg" alt="Sopa de queso y brócoli"></div>
          <h3>Sopa de Queso y Brócoli</h3>
          <p>Cremosa, reconfortante y lista en 20 minutos.</p>
        </article>

        <article class="card" data-type="blog">
          <span class="label blog">Blog</span>
          <div class="img-placeholder"><img src="<?php echo $page_data['assets_path']; ?>/images/post/impacto-ambiental-lecheria.jpg" alt="Lechería y sostenibilidad"></div>
          <h3>El impacto ambiental de la lechería sostenible</h3>
          <p>Cómo cuidamos el planeta mientras producimos lácteos de calidad.</p>
        </article>
      </div>
    </section>

    <!-- Paginación horizontal -->
    <div class="pagination" id="pagination" aria-label="Paginación">
      <button id="prev-page" aria-label="Página anterior">&lt;</button>
      <div id="page-numbers" class="page-numbers-horizontal"></div>
      <button id="next-page" aria-label="Página siguiente">&gt;</button>
    </div>
  </main> 

  <!-- Modal para Receta -->
<div id="modal-receta" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <button class="modal-close" aria-label="Cerrar modal">&times;</button>
      <h2>Flan Casero con Leche Fresca</h2>
      <div class="modal-subtitle">Receta tradicional | Tiempo: 60 min | Dificultad: Fácil</div>
    </div>
    <div class="modal-content">
      <div class="modal-description">
        Un postre tradicional hecho con nuestra leche entera fresca. Su textura suave y cremosa, combinada con el dulce caramelo, lo convierte en el favorito de la familia. Perfecto para ocasiones especiales o para disfrutar un día cualquiera.
      </div>
      
      <div class="modal-section">
        <h3>Ingredientes</h3>
        <ul class="ingredientes-list">
          <li>1 litro de leche entera Don Joaquín</li>
          <li>5 huevos grandes</li>
          <li>200g de azúcar (para el caramelo)</li>
          <li>100g de azúcar (para el flan)</li>
          <li>1 cucharadita de esencia de vainilla</li>
          <li>Ralladura de 1 limón (opcional)</li>
        </ul>
      </div>
      
      <div class="modal-section">
        <h3>Preparación</h3>
        <ol class="pasos-list">
          <li>Precalienta el horno a 180°C.</li>
          <li>Prepara el caramelo: en una flanera, derrite 200g de azúcar a fuego medio hasta obtener un caramelo dorado. Distribúyelo por toda la base y lados del molde.</li>
          <li>En un bol grande, bate los huevos con 100g de azúcar hasta que estén espumosos.</li>
          <li>Añade la leche Don Joaquín poco a poco mientras sigues batiendo.</li>
          <li>Agrega la esencia de vainilla y la ralladura de limón si la usas. Mezcla bien.</li>
          <li>Cuela la mezcla para eliminar cualquier grumo.</li>
          <li>Vierte la mezcla en la flanera con el caramelo.</li>
          <li>Coloca la flanera en una bandeja para horno con agua caliente (baño María).</li>
          <li>Hornea por 45-50 minutos o hasta que al insertar un cuchillo, este salga limpio.</li>
          <li>Deja enfriar a temperatura ambiente y luego refrigera por al menos 4 horas.</li>
          <li>Desmolda cuidadosamente y sirve frío.</li>
        </ol>
      </div>
      
      <div class="modal-section">
        <h3>Consejo del Chef</h3>
        <p>Para un flan aún más cremoso, sustituye 200ml de leche por crema de leche Don Joaquín. La calidad de la leche fresca hace toda la diferencia en el resultado final.</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Blog -->
<div id="modal-blog" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <button class="modal-close" aria-label="Cerrar modal">&times;</button>
      <h2>Beneficios de la Leche Fresca</h2>
      <div class="modal-subtitle">Salud y Nutrición | Actualizado: Marzo 2024</div>
    </div>
    <div class="modal-content">
      <div class="modal-description">
        La leche fresca de vacas alimentadas con pasto natural no solo es más sabrosa, sino también más nutritiva. Descubre por qué deberías preferirla en tu dieta diaria.
      </div>
      
      <div class="contenido-blog">
        <h3>Mayor Valor Nutricional</h3>
        <p>La leche proveniente de vacas que pastan libremente contiene niveles más altos de ácidos grasos omega-3, vitamina E y beta-caroteno en comparación con la leche de vacas en confinamiento. Estos nutrientes son esenciales para la salud cardiovascular y el sistema inmunológico.</p>
        
        <h3>Perfil Lipídico Mejorado</h3>
        <p>Estudios demuestran que la leche de pastoreo tiene una proporción más saludable de ácidos grasos, con mayor contenido de ácido linoleico conjugado (CLA), que se asocia con beneficios antiinflamatorios y propiedades que pueden ayudar en la gestión del peso.</p>
        
        <h3>Mejor Sabor y Textura</h3>
        <p>La alimentación natural y el manejo cuidadoso del ganado resultan en una leche con sabor más intenso y cremosidad natural. Muchos consumidores notan la diferencia desde el primer sorbo: un sabor limpio, fresco y ligeramente dulce que recuerda a la leche de antaño.</p>
        
        <h3>Sostenibilidad y Bienestar Animal</h3>
        <p>Elegir leche de pastoreo apoya sistemas de producción más sostenibles donde las vacas disfrutan de una vida más natural. Estas prácticas no solo son mejores para los animales, sino que también contribuyen a la salud del suelo y reducen la huella ambiental de la producción láctea.</p>
        
        <h3>Consejos para Identificar Leche de Calidad</h3>
        <p>Busca leche con fecha de caducidad próxima (indica menos procesamiento), de color ligeramente amarillento (por el beta-caroteno natural), y preferiblemente de productores locales que especifiquen "de pastoreo" o "grass-fed" en su etiquetado.</p>
        
        <p>En Lácteos Don Joaquín, nuestras vacas pastan libremente durante todo el año, garantizando no solo su bienestar sino también la máxima calidad nutricional en cada litro de leche que producimos.</p>
      </div>
    </div>
  </div>
</div>
  
  <script src="<?php echo $page_data['assets_path']; ?>/js/Blogjs.js"></script>
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

</body>
</html>