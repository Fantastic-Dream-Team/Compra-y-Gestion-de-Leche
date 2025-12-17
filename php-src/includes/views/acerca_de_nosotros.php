<?php


// Configuración de rutas (igual que productores.php)
$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$assets = $base_url . '/assets';

// Definir página actual
$pagina_actual = 'acerca-de-nosotros';

// Datos para la página (igual estructura que productores.php)
$page_data = [
    'page_title' => 'Acerca de Nosotros - Lácteos Don Joaquín',
    'current_page' => $pagina_actual,
    'assets_path' => $assets,
    'base_url' => $base_url,
    'current_year' => date('Y')
];

$titulo = $page_data['page_title'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_data['page_title']; ?></title>
    <link rel="icon" href="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/reseteo.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/styles.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/acercade.css">
    <link rel="stylesheet" href="<?php echo $page_data['assets_path']; ?>/css/font-awesome.min.css">
</head>
<body>
    <!-- HEADER (IGUAL QUE PRODUCTORES.PHP) -->
    <header>
        <div class="top-bar"></div>
        <div id="barra-negra"></div>
        <div id="barra-principal">
            <div class="informacion-contacto">
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Av. Principal 123</li>
                    <li><i class="fas fa-store"></i> Sucursal Centro</li>
                    <li><i class="fas fa-store"></i> Sucursal Norte</li>
                    <li><i class="fas fa-phone"></i> (123) 456-7890</li>
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
            <img id="logo" src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo de Lácteos Don Joaquín">
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
            <h1 id="titulo-bienvenida">Acerca de Nosotros</h1>
            <p class="subtitulo-bienvenida">Más de 50 años de tradición familiar en productos lácteos</p>
        </section>
    </header>

    <div class="acerca-container">
        <!-- NUESTRA HISTORIA -->
        <section id="historia" class="acerca-section fade-in">
            <div class="section-header">
                <h2>Nuestra Historia</h2>
                <div class="divider"></div>
            </div>
            
            <div class="history-content">
                <div class="history-text">
                    <p>En 1970, en las fértiles tierras del Valle Central, Don Joaquín Martínez fundó lo que sería el inicio de una tradición familiar. Con apenas tres vacas y un profundo conocimiento heredado de sus antepasados, comenzó a elaborar queso artesanal en un pequeño taller detrás de su casa.</p>
                    
                    <p>Su dedicación y pasión por la calidad pronto hicieron que sus productos fueran reconocidos en la comunidad local. Don Joaquín se levantaba antes del amanecer para ordeñar las vacas personalmente y supervisaba cada etapa del proceso, asegurándose de que cada queso cumpliera con sus altos estándares.</p>
                    
                    <p>Hoy, dirigida por la tercera generación de la familia Martínez, Lacteos Don Joaquín mantiene viva la filosofía de su fundador. Hemos crecido para convertirnos en una empresa moderna que combina tecnología de punta con métodos tradicionales, pero nunca hemos perdido de vista nuestros valores fundamentales.</p>
                    
                    <p>Contamos con más de 200 hectáreas de pastizales naturales donde nuestras vacas se alimentan libremente, y trabajamos directamente con pequeños productores locales, promoviendo prácticas sostenibles y asegurando un comercio justo para todos.</p>
                </div>
                <div class="history-image">
                    <!-- IMAGEN LOCAL -->
                    <img src="<?php echo $page_data['assets_path']; ?>/images/nuestra-historia.jpg" alt="Historia de Lacteos Don Joaquín">
                    <div class="image-caption">La Casa Don Joaquín, su primera quesería (1975)</div>
                </div>
            </div>
        </section>

        <!-- MISIÓN Y VISIÓN -->
        <section id="mision" class="acerca-section fade-in">
            <div class="section-header">
                <h2>Misión y Visión</h2>
                <div class="divider"></div>
            </div>
            
            <div class="mission-vision-grid">
                <div class="mission-card">
                    <div class="mv-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Nuestra Misión</h3>
                    <p>Producir y comercializar productos lácteos de la más alta calidad, manteniendo los métodos artesanales tradicionales combinados con tecnología moderna, para satisfacer las necesidades de nuestros clientes y contribuir al bienestar de nuestra comunidad.</p>
                </div>
                
                <div class="vision-card">
                    <div class="mv-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Nuestra Visión</h3>
                    <p>Ser reconocidos como líderes en la industria láctea a nivel nacional para 2025, expandiendo nuestra presencia comercial mientras mantenemos nuestros valores familiares y compromiso con la sostenibilidad ambiental y el desarrollo comunitario.</p>
                </div>
            </div>
        </section>

        <!-- VALORES -->
        <section class="acerca-section fade-in">
            <div class="section-header">
                <h2>Nuestros Valores</h2>
                <div class="divider"></div>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <i class="fas fa-heart"></i>
                    <h4>Pasión</h4>
                    <p>Amamos lo que hacemos y ponemos corazón en cada producto.</p>
                </div>
                
                <div class="value-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Calidad</h4>
                    <p>No comprometemos la excelencia en ningún proceso.</p>
                </div>
                
                <div class="value-card">
                    <i class="fas fa-handshake"></i>
                    <h4>Honestidad</h4>
                    <p>Transparencia en todas nuestras relaciones comerciales.</p>
                </div>
                
                <div class="value-card">
                    <i class="fas fa-leaf"></i>
                    <h4>Sostenibilidad</h4>
                    <p>Cuidamos el medio ambiente y el bienestar animal.</p>
                </div>
            </div>
        </section>

        <!-- TESTIMONIOS -->
        <section id="testimonios" class="testimonials-section fade-in">
            <div class="section-header">
                <h2>Palabras de Nuestros Amigos</h2>
                <div class="divider"></div>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Los productos de Lacteos Don Joaquín son excepcionales. Como chef, valoro la calidad y consistencia de sus quesos. ¡Son insuperables!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">CR</div>
                        <div class="author-info">
                            <h4>Carlos Rodríguez</h4>
                            <span>Chef Ejecutivo - Restaurante "El Mirador"</span>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Por tres generaciones, nuestra familia ha confiado en Lacteos Don Joaquín. Su queso es el más puro y delicioso que hemos encontrado."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">MG</div>
                        <div class="author-info">
                            <h4>María González</h4>
                            <span>Cliente desde 1985</span>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Como distribuidor, aprecio su puntualidad y la excelente relación calidad-precio. Una empresa confiable y profesional."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">RS</div>
                        <div class="author-info">
                            <h4>Roberto Sánchez</h4>
                            <span>Distribuidor Regional</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Como nutricionista, recomiendo los productos de Lacteos Don Joaquín por su pureza y valor nutricional. Son esenciales para una dieta balanceada y saludable."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">LA</div>
                        <div class="author-info">
                            <h4>Laura Álvarez</h4>
                            <span>Nutricionista - Clínica "Salud Integral"</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- EQUIPO -->
        <section class="acerca-section equipo-section fade-in">
            <div class="section-header">
                <h2>Nuestro Equipo</h2>
                <div class="divider"></div>
            </div>
            
            <div class="equipo-grid">
                <div class="miembro-equipo">
                    <div class="miembro-foto">
                        <!-- IMAGEN LOCAL -->
                        <img src="<?php echo $page_data['assets_path']; ?>/images/director-general.jpeg" alt="Juan Martínez - Director General">
                    </div>
                    <div class="miembro-info">
                        <h3>Juan Martínez</h3>
                        <p class="cargo">Director General</p>
                        <p class="descripcion">Nieto del fundador, lidera la empresa con visión innovadora manteniendo las tradiciones familiares.</p>
                    </div>
                </div>
                
                <div class="miembro-equipo">
                    <div class="miembro-foto">
                        <!-- IMAGEN LOCAL -->
                        <img src="<?php echo $page_data['assets_path']; ?>/images/gerente-prod.jpeg" alt="María Rodríguez - Gerente de Producción">
                    </div>
                    <div class="miembro-info">
                        <h3>María Rodríguez</h3>
                        <p class="cargo">Gerente de Producción</p>
                        <p class="descripcion">15 años de experiencia en control de calidad y procesos de fabricación láctea.</p>
                    </div>
                </div>
                
                <div class="miembro-equipo">
                    <div class="miembro-foto">
                        <!-- IMAGEN LOCAL -->
                        <img src="<?php echo $page_data['assets_path']; ?>/images/jefe-ventas.jpeg" alt="Carlos Gutiérrez - Jefe de Ventas">
                    </div>
                    <div class="miembro-info">
                        <h3>Carlos Gutiérrez</h3>
                        <p class="cargo">Jefe de Ventas</p>
                        <p class="descripcion">Especialista en expansión comercial y relaciones con distribuidores.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FOOTER (IGUAL QUE PRODUCTORES.PHP) -->
    <footer class="footer">
        <div class="logo">
            <img src="<?php echo $page_data['assets_path']; ?>/images/LogoBlanco.png" alt="Logo Lácteos Don Joaquín" width="150" height="80">
        </div>

        <div class="social">
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            <a href="mailto:info@lacteosdonjoaquin.com" aria-label="Correo electrónico"><i class="fas fa-envelope"></i> Email</a>
        </div>

        <div class="derechos">
            <p>&copy; <?php echo $page_data['current_year']; ?> Lácteos Don Joaquín. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo $page_data['assets_path']; ?>/js/funciones.js"></script>
    <script src="<?php echo $page_data['assets_path']; ?>/js/acerca_de_nosotros.js"></script>

</body>
</html>