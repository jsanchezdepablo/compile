<?php 

	session_start();

	if(!isset($_SESSION['email'])){
		echo '<script> window.location.replace("http://localhost/compila.es/login.php");</script>';
	}
?>