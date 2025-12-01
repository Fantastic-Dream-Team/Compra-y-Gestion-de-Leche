<?php
session_start();

define('BASE_PATH', __DIR__);
define('ASSETS_PATH', 'assets');
define('INCLUDES_PATH', BASE_PATH . '/includes');

require_once INCLUDES_PATH . '/config.php'; // Comentario: Requiere config para BD en todas las vistas.

$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

$path = str_replace(dirname($script_name), '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// ... (tu código de static extensions sigue igual)

// Comentario: Rutas actualizadas con nuevas páginas dinámicas.
$routes = [
    '' => 'home.php',
    'home' => 'home.php',
    'productos' => 'Productos.php', // Nueva: dinámica con BD
    'blog' => 'Blog.php',           // Nueva: dinámica con BD
    'productores-y-pedidos' => 'productores-pedidos.php',
    'productores' => 'productores.php',
    'acerca-de-nosotros' => 'acerca-de-nosotros.php'
];

if (array_key_exists($path, $routes)) {
    $view_file = $routes[$path];
    $view_path = INCLUDES_PATH . '/views/' . $view_file;
    
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        http_response_code(404);
        echo "Página no encontrada.";
    }
} else {
    require_once INCLUDES_PATH . '/views/home.php';
}