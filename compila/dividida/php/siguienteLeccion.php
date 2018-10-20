<?php 

	require_once 'conexionBD.php';

	$id    = $_GET['id'];
	$leccion = $_GET['leccion'];
	$usu = $_GET['email'];

	$sql = "UPDATE curso_usuario SET Lecc_Completadas=Lecc_Completadas+1 WHERE Email_Usu = '$usu' AND Id_Curso = $id";

	if(mysqli_query($conn,$sql)){
		echo "Todo guay";
	}else{
		$msg="Algo ha ido mal: ".mysqli_error($conn);
		echo $msg;
	}  

?>