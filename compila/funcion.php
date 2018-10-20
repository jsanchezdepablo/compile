<?php

	require_once 'funcionesPhp.php';

	$usu   = $_GET['usu'];
	$id    = $_GET['id'];
	$leido = $_GET['leido'];

	if($leido == 1)
		$sql = "UPDATE noticia_usuario nu SET Leido = 0 WHERE nu.Id_Usuario = '$usu' AND nu.Id_Noticia = $id ";

	else
		$sql = "UPDATE noticia_usuario nu SET Leido = 1 WHERE nu.Id_Usuario = '$usu' AND nu.Id_Noticia = $id ";


	mysqli_query($conn,$sql);


?>