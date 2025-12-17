<?php
/**
 * Sistema de Gestión de Lácteos Don Joaquín
 * Punto de entrada principal - Silver7-7
 */

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Configuración
define('BASE_PATH', __DIR__);
define('ASSETS_PATH', '/Compra-y-Gestion-de-Leche/php-src/assets');
define('INCLUDES_PATH', BASE_PATH . '/includes');
define('BASE_URL', '/Compra-y-Gestion-de-Leche/php-src');


// Cargar configuración si existe
if (file_exists(INCLUDES_PATH . '/conexion.php')) {
    require_once INCLUDES_PATH . '/conexion.php';
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

// ----------------------------------------------------------
// SERVIR ARCHIVOS ESTÁTICOS DIRECTAMENTE (CSS, JS, imágenes, etc.)
// ----------------------------------------------------------
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

$request = str_replace(dirname($script_name), '', parse_url($request_uri, PHP_URL_PATH));

if (preg_match('#^/assets/#', $request)) {
    return false; // Dejar que Apache sirva el archivo directamente
}

// ENRUTAMIENTO EXACTO SEGÚN TU MENÚ
$routes = [
    '' => 'home.php',
    'home' => 'home.php',
    'productos-y-pedidos' => 'productos-y-pedidos.php',
    'productores' => 'productores.php',
    'blog' => 'blog.php',
    'acerca-de-nosotros' => 'acerca_de_nosotros.php',
    'panel-productor' => 'panel_productor.php',
    'login' => 'login.php'

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