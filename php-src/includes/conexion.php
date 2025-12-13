<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "donjoaquin";
<<<<<<< Updated upstream
<<<<<<< Updated upstream
$port       = 3308;   
=======
$port       = 3308;
>>>>>>> Stashed changes
=======
$port       = 3308;
>>>>>>> Stashed changes

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>