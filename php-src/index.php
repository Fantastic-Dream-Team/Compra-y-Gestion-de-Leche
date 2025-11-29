<?php
session_start();

define('BASE_PATH', __DIR__);
define('ASSETS_PATH', 'assets');
define('INCLUDES_PATH', BASE_PATH . '/includes');

if (file_exists(INCLUDES_PATH . '/config.php')) {
    require_once INCLUDES_PATH . '/config.php';
} else {
    define('APP_NAME', 'Lácteos Don Joaquín');
    define('APP_DEBUG', true);
}

$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

$path = str_replace(dirname($script_name), '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$extension = strtolower(pathinfo($uri_path, PATHINFO_EXTENSION));

$static_extensions = [
    'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'ico', 'svg',
    'webp', 'woff', 'woff2', 'ttf', 'otf', 'eot'
];

if (in_array($extension, $static_extensions)) {
    return false;
}

if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|webp|ico|woff|woff2|ttf|otf|eot)$/i', $uri_path)
    && !file_exists(__DIR__ . $uri_path)) {
    header('HTTP/1.0 404 Not Found');
    exit('Archivo no encontrado');
}

$routes = [
    '' => 'home.php',
    'home' => 'home.php',
    'productores-y-pedidos' => 'productores-pedidos.php',
    'productores' => 'productores.php',
    'blog' => 'blog.php',
    'acerca-de-nosotros' => 'acerca-de-nosotros.php'
];

if (array_key_exists($path, $routes)) {
    $view_file = $routes[$path];
    $view_path = INCLUDES_PATH . '/views/' . $view_file;
    
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        http_response_code(404);
    }
} else {
    require_once INCLUDES_PATH . '/views/home.php';
}