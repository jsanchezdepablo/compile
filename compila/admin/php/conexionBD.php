<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="elrinco7_compila";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo '<script>console.log("'.die("Conexion fallida a la BD: " . mysqli_connect_error()).')!")</script>';
}else{
	echo '<script>console.log("Conectado con éxito a la BD!")</script>';
}


?>