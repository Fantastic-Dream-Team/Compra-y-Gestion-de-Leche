<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "donjoaquin";
$port       = 3308;   

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>