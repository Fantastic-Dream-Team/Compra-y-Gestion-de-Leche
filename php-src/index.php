<?php
/**
 * Sistema de Gestión de Lácteos Don Joaquín
 * Punto de entrada principal - Silver7-7
 */

session_start();

// Configuración
define('BASE_PATH', __DIR__);
define('ASSETS_PATH', '/Compra-y-Gestion-de-Leche/php-src/assets');
define('INCLUDES_PATH', BASE_PATH . '/includes');

// Cargar configuración si existe
if (file_exists(INCLUDES_PATH . '/config.php')) {
    require_once INCLUDES_PATH . '/config.php';
} else {
    // Configuración básica
    define('APP_NAME', 'Lácteos Don Joaquín');
    define('APP_DEBUG', true);
}

// Sistema de rutas
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

// Obtener ruta limpia
$path = str_replace(dirname($script_name), '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Servir archivos estáticos directamente
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2)$/', $request_uri)) {
    return false;
}

// ENRUTAMIENTO EXACTO SEGÚN TU MENÚ
$routes = [
    '' => 'home.php',                                  // http://localhost/tu-proyecto/
    'home' => 'home.php',                              // http://localhost/tu-proyecto/home
    'productores-y-pedidos' => 'productores-pedidos.php', // http://localhost/tu-proyecto/productores-y-pedidos
    'productores' => 'productores.php',                // http://localhost/tu-proyecto/productores
    'blog' => 'blog.php',                              // http://localhost/tu-proyecto/blog
    'acerca-de-nosotros' => 'acerca-de-nosotros.php'   // http://localhost/tu-proyecto/acerca-de-nosotros
];

// Encontrar ruta
if (array_key_exists($path, $routes)) {
    $view_file = $routes[$path];
    $view_path = INCLUDES_PATH . '/views/' . $view_file;
    
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        http_response_code(404);
        require_once INCLUDES_PATH . '/views/404.php';
    }
} else {
    // Redirigir a home si no se encuentra la ruta
    require_once INCLUDES_PATH . '/views/home.php';
}
?>