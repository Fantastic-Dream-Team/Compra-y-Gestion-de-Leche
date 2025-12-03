<?php
// test.php - Archivo de diagnóstico
echo "<h1>Test de diagnóstico</h1>";

echo "<h2>1. PHP funciona ✓</h2>";

echo "<h2>2. Información del servidor:</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "</pre>";

echo "<h2>3. Constantes definidas:</h2>";
define('BASE_PATH', __DIR__);
define('ASSETS_PATH', 'assets');
define('INCLUDES_PATH', BASE_PATH . '/includes');

echo "<pre>";
echo "BASE_PATH: " . BASE_PATH . "\n";
echo "ASSETS_PATH: " . ASSETS_PATH . "\n";
echo "INCLUDES_PATH: " . INCLUDES_PATH . "\n";
echo "</pre>";

echo "<h2>4. Verificación de archivos:</h2>";
$archivos_verificar = [
    'includes/views/productores.php',
    'assets/css/reseteo.css',
    'assets/css/styles.css',
    'assets/css/styleProductores.css',
    'assets/javascript/NProductores.js',
    'assets/images/LogoBlanco.png',
    'includes/conexion.php'
];

echo "<ul>";
foreach ($archivos_verificar as $archivo) {
    $ruta = BASE_PATH . '/' . $archivo;
    $existe = file_exists($ruta);
    $color = $existe ? 'green' : 'red';
    $texto = $existe ? '✓ EXISTE' : '✗ NO EXISTE';
    echo "<li style='color: $color;'><strong>$archivo</strong>: $texto</li>";
}
echo "</ul>";

echo "<h2>5. Test de conexión a base de datos:</h2>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donjoaquin";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'>✗ Error de conexión: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>✓ Conexión exitosa a la base de datos</p>";
        
        // Verificar si existen las tablas
        $result = $conn->query("SHOW TABLES");
        echo "<p>Tablas encontradas:</p><ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>{$row[0]}</li>";
        }
        echo "</ul>";
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Excepción: " . $e->getMessage() . "</p>";
}

echo "<h2>6. Estructura de directorios:</h2>";
echo "<pre>";
function listarDirectorio($dir, $prefix = '') {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo $prefix . $file;
        if (is_dir($dir . '/' . $file)) {
            echo "/\n";
            listarDirectorio($dir . '/' . $file, $prefix . '  ');
        } else {
            echo "\n";
        }
    }
}
listarDirectorio(BASE_PATH);
echo "</pre>";

echo "<hr>";
echo "<h2>7. Prueba de carga de productores.php:</h2>";
echo "<a href='productores' style='font-size: 20px; padding: 10px 20px; background: #f5712f; color: white; text-decoration: none; border-radius: 5px;'>IR A PRODUCTORES</a>";
?>