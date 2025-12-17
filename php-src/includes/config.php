<?php

// includes/config.php
// Comentario: Este es tu archivo de conexión, solo lo mejoramos un poco

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donjoaquin";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Comentario: Función auxiliar para consultas más limpias (opcional pero útil)
function query($sql, $params = [])
{
    global $conn;
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en prepare: " . $conn->error);
    }
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // asumimos todo string por simplicidad
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}
