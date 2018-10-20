

<?php

// --------------------------------------------------- Conexion a la BD ---------------------------------------------


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
	// echo '<script>console.log("Conectado con éxito a la BD!")</script>';	
}



// ------------------------------------------------ Conexion a la BD --------------------------------------------------





//------------------------------------------------- VARIABLES GLOBALES -------------------

$funciona = "";




session_start();  //Siempre que se vayan a utilizar algo de sesiones hay que abrir sesion
// mysql_set_charset('utf8');



function addUsu(){

        // echo '<script>console.log("Estoy en la funcion")</script>';


	//Declaro la var como global para poder acceder a ella dentro de la funcion
	global $conn, $funciona; 



	if(strcmp($_POST['pass'],$_POST['pass2'])==0){
		
		$pasEnc=md5($_POST['pass']);
		// echo '<script>console.log("'. $pasEnc . '")</script>';
       
		$sql="INSERT INTO usuario (Email, Password) VALUES ('$_POST[correo]', '$pasEnc')";
		if(mysqli_query($conn,$sql)){
			$funciona = true;
			msgExito();
			sendEmailVerification($_POST['correo']);


		}else{

			if(mysqli_errno($conn) == 1062){
			    $funciona = false;
			    msgErrorCorreo($_POST['correo']);
			}
		}
	}
   
}


function addUsuFace($email, $nom, $ape){


	global $conn, $funciona; 

	$var = 'antonio@gg.com';

	echo "<script> console.log('ME AÑADO')</script>";
       
	$sql="INSERT INTO usuario (Email, Nombre, Apellidos) VALUES ($var, $nom, $ape)";
	if(mysqli_query($conn,$sql)){
		$funciona = true;

		echo "<script> console.log('REGISTROOO')</script>";
		msgExito();
		


	}else{

		if(mysqli_errno($conn) == 1062){
		    $funciona = false;
		    msgErrorCorreo($email);
		}
	}

}


function loginUsuFace($email){

	global $conn;

	$sql = "SELECT u.Email FROM usuario u WHERE u.Email = $email ";	

	echo "<script> console.log('LOGIIIIIIIIN')</script>";

	$result = $conn->query($sql);

	// Enctripto el pass introducido para compararlo con el que hay en la BD
	// $pasEnc= md5($_POST['pass']);

	if($result->num_rows > 0){ //He encontrado un usuario con ese email, EXISTE EN LA BD!
		while($row =  $result->fetch_assoc()){ //Devuelve un array con la info del result

			//***2a SELECT PARA COMPROBAR LA CONTRASEÑA DEL USUARIO
               $sql2="SELECT * FROM usuario u WHERE u.Email= $email";
               $result2 = mysqli_query($conn, $sql2);

               
               while($row2 = mysqli_fetch_assoc($result2)){
		  
		   // if(strcmp($pasEnc,$row2['Password'])==0){  //****COMPRUEBO QUE LAS CONTRASEÑAS COINCIDEN
		   	// var_dump($row2['Password']);
		       
		       $_SESSION["email"] = $row2["Email"];
		       // $_SESSION["pass"] = $row2["Password"];
		       $_SESSION["nombre"] = $row2["Nombre"];
		       // $_SESSION["apellidos"] = $row2["Apellidos"];
		       // $_SESSION["foto"] = $row2["Foto"];

                  	header('Location: /compila/misCursos.php');

		       // var_dump($_SESSION["email"]);

		 
            	}
	}

	}else{
      $error = "El usuario y/o la contraseña con incorrectos.";
      errorInicio($error);
  	}

     	


}





function loginUsu(){

	// echo $_POST['recuerda'];


	// session_start(); //Siempre que se vayan a utilizar algo de sesiones hay que abrir sesion

	$error=""; //*SI ALGUNO DE LOS CAMPOS ESTA VACIO -- ERROR

	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

       if (empty($_POST['correo']) || empty($_POST['pass'])) {
            $error = "Tienes que rellenar todos los campos.";
            errorInicio($error);

     	}else{
     		$sql = "SELECT u.Email FROM usuario u WHERE u.Email ='". $_POST['correo']."'";	
     		$result = $conn->query($sql);

     		// Enctripto el pass introducido para compararlo con el que hay en la BD
     		$pasEnc= md5($_POST['pass']);

     		if($result->num_rows > 0){ //He encontrado un usuario con ese email, EXISTE EN LA BD!
     			while($row =  $result->fetch_assoc()){ //Devuelve un array con la info del result

	     			//***2a SELECT PARA COMPROBAR LA CONTRASEÑA DEL USUARIO
	                    $sql2="SELECT * FROM usuario u WHERE u.Email='".$_POST['correo']."'";
	                    $result2 = mysqli_query($conn, $sql2);

	                    
	                    while($row2 = mysqli_fetch_assoc($result2)){
				  
				   if(strcmp($pasEnc,$row2['Password'])==0){  //****COMPRUEBO QUE LAS CONTRASEÑAS COINCIDEN
				   	// var_dump($row2['Password']);
				       
				       $_SESSION["email"] = $row2["Email"];
				       $_SESSION["pass"] = $row2["Password"];
				       $_SESSION["nombre"] = $row2["Nombre"];
				       $_SESSION["apellidos"] = $row2["Apellidos"];
				       // $_SESSION["foto"] = $row2["Foto"];

                            	header('Location: /compila/misCursos.php');

				       // var_dump($_SESSION["email"]);

				   }else{
				       $error = "El usuario y/o la contraseña son incorrectos.";
				       errorInicio($error);
				   }
	                 	}
			}

     		}else{
                $error = "El usuario y/o la contraseña con incorrectos.";
                errorInicio($error);
            	}

     	}

     	// recuerdame();

}




function eliminarSesion(){

	session_destroy();
	setcookie("email_google","caca", time() - 3600,"/","");
	setcookie("foto_google","caca", time() - 3600,"/","");
	header("Location: /compila/index.php");


	unset($_SESSION['access_token']);
    	header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);




    	if (isset($_SERVER['HTTP_COOKIE'])) {
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
	        $parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        setcookie($name, '', time()-1000);
	        setcookie($name, '', time()-1000, '/');
	    }
	}



}


function eliminarSesionFace(){

	unset($_SESSION['fb_access_token']);
}



function recuerdame(){

	// session_start();

	echo "<script> console.log('HOLAAAAAAAAAA')</script>";
	setcookie("nombre_usu", $_SESSION["email"], time() + 3600);
	setcookie("pass_usu", $_SESSION["pass"], time() + 3600);

}



function comprobarSesion($num){

	// global $activo;
	// session_start(); //Siempre que se vayan a utilizar algo de sesiones hay que abrir sesion


	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion
       


	if(isset($_SESSION['email'])){

		$menuRe = '<nav class="navbar navbar-default navbar-fixed-top " style="opacity: 1">';
		$menuRe.= 	'<div class="container ">';
		$menuRe.= 		'<div class="navbar-header navegador">';
		$menuRe.= 			'<button type="button " class="navbar-toggle" data-toggle= "collapse" data-target=".navbar-ex1-collapse">';
		$menuRe.= 				'<span class="sr-only ">Desplegar navegacion</span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 			'</button>';
		$menuRe.= 			'<a class="navbar-right" href="index.php"><h1 class="subir">Compila!</h1></a>';
		$menuRe.= 		'</div>';
		$menuRe.= 		'<div class="collapse navbar-collapse navbar-ex1-collapse">';
		$menuRe.=			'<ul class="nav navbar-nav navbar-right enlaces">';


		if($num == 5)
			$menuRe .= '<li class="active"><a href="misCursos.php">Mis cursos</a></li>';
		else
			$menuRe .= '<li><a href="misCursos.php">Mis cursos</a></li>';


		if($num == 2)
			$menuRe .= '<li class="active" ><a href="cursos.php ">Cursos</a></li>';
		else
			$menuRe .= '<li><a href="cursos.php ">Cursos</a></li>';

		if($num == 3)
			$menuRe .= '<li class="active"><a href="noticias.php ">Noticias</a></li>';
		else
			$menuRe .= '<li><a href="noticias.php ">Noticias</a></li>';

	

		// $menuRe.= 				'<li class="'.$activo.'"><a href="index.php?activo=1">Inicio</a></li>';
		// $menuRe.= 				'<li><a href="cursos.php ">Cursos</a></li>';
		// $menuRe.= 				'<li><a href="noticias.php ">Noticias</a></li>';
		// $menuRe.=							'<li><a href="perfil.php">Mi perfil</a></li>';
		// $menuRe.=							'<li class=""><a href="misCursos.php">Mis cursos</a></li>';





		$menuRe.= 				'<li class="dropdown">';

// echo $_SESSION['fotoGoo']

		$sql = "SELECT * FROM usuario WHERE Email ='". $_SESSION['email']."'";	
		$aux = ".";
		$porcentaje = 0;
		$result = $conn->query($sql);
		if($result->num_rows > 0){ 
     		while($row = mysqli_fetch_assoc($result)){


				if(isset($_SESSION['fotoFace'])){
					$menuRe.='<a href="perfil.php" class="dropdown-toggle" data-toggle="dropdown"><img src="//graph.facebook.com/'.$_SESSION['id'].'/picture" class="img-circle" alt="Cinque Terre" width="25" height="25"></a>';

				}else if(isset($_COOKIE['foto_google'])){

					$menuRe.='<a href="perfil.php" class="dropdown-toggle" data-toggle="dropdown"><img src="'.$_COOKIE['foto_google'].'" class="img-circle" alt="Cinque Terre" width="25" height="25"></a>';


				}else{

					if($row["Foto"] != NULL)
						$menuRe.='<a href="perfil.php" class="dropdown-toggle" data-toggle="dropdown"><img src="imagenes/usuarios/'.$row["Email"].$aux.$row["Foto"].'" class="img-circle" alt="Cinque Terre" width="25" height="25"></a>';
				
					else
						$menuRe.='<a href="perfil.php" class="dropdown-toggle" data-toggle="dropdown"><img src="imagenes/usuarios/sinFoto.jpg" class="img-circle" alt="Cinque Terre" width="25" height="25"></a>';
				}
	

				$menuRe.=						'<ul class="dropdown-menu">';



				$cont = $row["Perfil_comp"];

				if($num == 4){

					if($cont == 0){
						$porcentaje = 10;
						$menuRe .= '<li class="active"><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p> Mi perfil</a></li>';

					}

					if($cont == 1){
						$porcentaje = 20;
						$menuRe .= '<li class="active"><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p> Mi perfil</a></li>';

					}

					if($cont == 2){
						$porcentaje = 40;
						$menuRe .= '<li class="active"><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p> Mi perfil</a></li>';

					}

					if($cont == 3){
						$porcentaje = 60;
						$menuRe .= '<li class="active"><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p> Mi perfil</a></li>';

					}

					if($cont == 4){
						$porcentaje = 80;
						$menuRe .= '<li class="active"><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p> Mi perfil</a></li>';

					}

					if($cont > 4){
						$menuRe .= '<li class="active"><a href="perfil.php">Mi perfil</a></li>';

					}

				}else{
					if($cont == 0){
						$porcentaje = 10;
						$menuRe .= '<li><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p>Mi perfil </a></li>';
					}

					if($cont == 1){
						$porcentaje = 20;
						$menuRe .= '<li><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p>Mi perfil </a></li>';

					}

					if($cont == 2){
						$porcentaje = 40;
						$menuRe .= '<li><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p>Mi perfil </a></li>';

					}

					if($cont == 3){
						$porcentaje = 60;
						$menuRe .= '<li><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p>Mi perfil </a></li>';

					}

					if($cont == 4){
						$porcentaje = 80;
						$menuRe .= '<li><a href="perfil.php"><p id="malrollo">'.$porcentaje.'%</p>Mi perfil </a></li>';

					}

					if($cont > 4){
						$menuRe .= '<li><a href="perfil.php">Mi perfil </a></li>';

					}
				}

			}	


		}

		



		




		$menuRe.= 							'<li><a href="index.php?salir=ok" style="color:red">Cerrar Sesión</a></li>';

		$menuRe.=						'</ul>';
		$menuRe.= 				'</li>';



		if(isset($_COOKIE['cantidad_carrito'])){
			//$numPedidos=json_decode($_COOKIE['cantidad_carrito']);
			//$numPedidos=count($numPedidos);
			$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
			$numPedidos=0;
			foreach ($datos as $i => $key){
				$numPedidos++;
			}

			if($num==23)		
				$menuRe.= 			'<li class="active"><a href="carrito.php"><span class="fa fa-shopping-cart carrito"></span><p id="cantCarrito">'.$numPedidos.'</p></a></li>'; /**FUCKK**/
			else 
				$menuRe.= 			'<li><a href="carrito.php"><span class="fa fa-shopping-cart carrito"></span><p id="cantCarrito">'.$numPedidos.'</p></a></li>'; /**FUCKK**/

		}else{
			$menuRe.= 			'<li><a href="#" class="disabled"><span class="fa fa-shopping-cart carrito"></span></a></li>'; /**FUCKK**/
		}



		$menuRe.= 			'</ul>';
		$menuRe.= 		'</div>';
		$menuRe.= 	'</div>';
		$menuRe.= '</nav>';
		

		echo $menuRe;
      
	}else{
		$menuRe = '<nav class="navbar navbar-default navbar-fixed-top " style="opacity: 1">';
		$menuRe.= 	'<div class="container ">';
		$menuRe.= 		'<div class="navbar-header navegador">';
		$menuRe.= 			'<button type="button " class="navbar-toggle" data-toggle= "collapse" data-target=".navbar-ex1-collapse">';
		$menuRe.= 				'<span class="sr-only ">Desplegar navegacion</span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 				'<span class="icon-bar "></span>';
		$menuRe.= 			'</button>';
		$menuRe.= 			'<a class="navbar-right" href="index.php "><h1 class="subir">Compila!</h1></a>';
		$menuRe.= 		'</div>';
		$menuRe.= 		'<div class="collapse navbar-collapse navbar-ex1-collapse">';
		$menuRe.=			'<ul class="nav navbar-nav navbar-right enlaces">';


		if($num == 1)
			$menuRe .= '<li class="active"><a href="index.php">Inicio</a></li>';
		else
			$menuRe .= '<li><a href="index.php">Inicio</a></li>';


		if($num == 2)
			$menuRe .= '<li class="active" ><a href="cursos.php ">Cursos</a></li>';
		else
			$menuRe .= '<li><a href="cursos.php ">Cursos</a></li>';

		if($num == 3)
			$menuRe .= '<li class="active"><a href="noticias.php ">Noticias</a></li>';
		else
			$menuRe .= '<li><a href="noticias.php ">Noticias</a></li>';

		if($num == 6)
			$menuRe .= '<li class="active"><a href="registro.php" class="reg"> Registro</a></li>';
		else
			$menuRe .= '<li><a href="registro.php" class="reg"> Registro</a></li>';


		if($num == 7)
			$menuRe .= '<li class="active"><a href="login.php" > Iniciar sesión</a></li>';
		else
			$menuRe .= '<li><a href="login.php" > Iniciar sesión</a></li>';


		// $menuRe.= 				'<li class="active"><a href="index.php">Inicio</a></li>';
		// $menuRe.= 				'<li><a href="cursos.php ">Cursos</a></li>';
		// $menuRe.= 				'<li><a href="noticias.php ">Noticias</a></li>';
		// $menuRe.= 				'<li><a href="registro.php" class="reg"> Registro</a></li>';
		// $menuRe.= 				'<li><a href="login.php" > Iniciar sesión</a></li>';




		if(isset($_COOKIE['cantidad_carrito'])){
			//$numPedidos=json_decode($_COOKIE['cantidad_carrito']);
			//$numPedidos=count($numPedidos);
			$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
			$numPedidos=0;
			foreach ($datos as $i => $key){
				$numPedidos++;
			}

			if($num==23)		
				$menuRe.= 			'<li class="active"><a href="carrito.php"><span class="fa fa-shopping-cart carrito"></span><p id="cantCarrito">'.$numPedidos.'</p></a></li>'; /**FUCKK**/
			else 
				$menuRe.= 			'<li><a href="carrito.php"><span class="fa fa-shopping-cart carrito"></span><p id="cantCarrito">'.$numPedidos.'</p></a></li>'; /**FUCKK**/

		}else{
			$menuRe.= 			'<li><a href="#" class="disabled"><span class="fa fa-shopping-cart carrito"></span></a></li>'; /**FUCKK**/
		}





		$menuRe.=			'</ul>';		
		$menuRe.= 		'</div>';
		$menuRe.= 	'</div>';
		$menuRe.= '</nav>';
		
		echo $menuRe;
	}

	// var_dump($_SESSION["email"]);
}


function comprobarSesion2(){

	if(!isset($_SESSION['email'])){

		$botones='<a  href="registro.php" class="btn btn-lg btn-success reg" id="botonReg" > Registro</a>';  
		$botones.='<a  href="login.php" class="btn btn-lg btn-default botonLog" id="botonIni" style="margin-left:0.5em"> Iniciar Sesión</a>'; 
		echo $botones;            
     }

}



function extraerCursos(){



	global $conn, $funciona; //Declaro la var como global para poder acceder a ella dentro de la funcion


	if(isset($_POST['buscador']) && $funciona == false){
          buscar_curso();

	}else{

		$sql = "SELECT * FROM curso WHERE Visible =1 ORDER BY F_creacion DESC";
		$aux= ".";	
		$result = $conn->query($sql);

		if($result->num_rows > 0){ //Hay cursos en la BD

	               
	     	while($row = mysqli_fetch_assoc($result)){

	     		$curso = '<div class="cursos margen2">';
	     		     if($row['Descuento'] == 0){
	
	                       

	                   	   $curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p></a>'; 

	                   }else{
	                   		$precioFinal = $row['Precio'] * ($row['Descuento']*0.01);
	                   	   	$precioFinal = $row['Precio'] - $precioFinal;
	                   		
	                   		$curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p><p class="a"><span class="a">'.$row['Descuento'].' %</span></p></a>'; 

	                   }


	     		
	     		$curso.= 		'<div class="dentro">';
	     		$curso.= 		'<h2 class="text-left">'.$row["Titulo"] .'</h2><hr>';
	     		$curso.= 		'<p class="text-left">' .$row["Descripcion"] .'</p>';
	     		$curso.= 		'<p class="text-left text-primary ">Tiempo estimado '.$row["Duracion"] .' horas</p></div>';
	     		$curso.= '</div>';

	     		echo $curso;
	     		$funciona = true;

	               // var_dump($row['Descripcion']);

			}
		}
	}

}





function cursosIndex(){

	global $conn, $funciona; //Declaro la var como global para poder acceder a ella dentro de la funcion

	$sql = "SELECT * FROM curso WHERE Visible =1 ORDER BY F_creacion DESC LIMIT 0, 4";
	$aux = ".";	
	$result = $conn->query($sql);

	if($result->num_rows > 0){ //Hay cursos en la BD

               
     	while($row = mysqli_fetch_assoc($result)){

     		$curso = '<div class="cursos margen2">';


		     if($row['Descuento'] == 0){

                  

              	   $curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p></a>'; 

              }else{
              		$precioFinal = $row['Precio'] * ($row['Descuento']*0.01);
              	   	$precioFinal = $row['Precio'] - $precioFinal;
              		
              		$curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p><p class="a"><span class="a">'.$row['Descuento'].' %</span></p></a>'; 

              }


	     		
	     		$curso.= 		'<div class="dentro">';
	     		$curso.= 		'<h2 class="text-left">'.$row["Titulo"] .'</h2><hr>';
	     		$curso.= 		'<p class="text-left">' .$row["Descripcion"] .'</p>';
	     		$curso.= 		'<p class="text-left text-primary ">Tiempo estimado '.$row["Duracion"] .' horas</p></div>';
	     		$curso.= '</div>';

	     		echo $curso;
     		$funciona = true;

               // var_dump($row['Descripcion']);

		}
	}
}



function buscar_curso(){


	global $conn,$funciona; //Declaro la var como global para poder acceder a ella dentro de la funcion

	$busqueda = trim($_POST['buscar']); //trim se usa para no dejar espacios al inicio
	$aux=".";

	$entero = 0;

	if(empty($busqueda)){
		
		// $texto = 'Debes escribir algo para poder buscar';
		$funciona = false;
		// mostrar_busqueda(msgError($texto));

	}else{
		// mysql_set_charset('utf8'); // mostramos la información en utf-8
		$sql = "SELECT * FROM curso WHERE Titulo LIKE '%$busqueda%' AND Visible = 1 ORDER BY Titulo";
		


		$resultado = $conn->query($sql);

		if ($resultado->num_rows > 0){ 
		     // Se recoge el número de resultados
			$registros = '<p>Hemos encontrado ' . $resultado->num_rows . ' resultado </p>';

			  // Se almacenan las cadenas de resultado
			while($row = mysqli_fetch_assoc($resultado)){
	              // $texto = $fila['Titulo'] . '<br />';
	              // $id = $fila['Id'];
	              $funciona = true;

	             $curso = '<div class="cursos margen2">';
	     		     if($row['Descuento'] == 0){
	
	                       

	                   	   $curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p></a>'; 

	                   }else{
	                   		$precioFinal = $row['Precio'] * ($row['Descuento']*0.01);
	                   	   	$precioFinal = $row['Precio'] - $precioFinal;
	                   		
	                   		$curso.= 	'<a href="curso.php?id='.$row["Id"].' " class="side-corner-tag"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "><p><span>'.$row['Precio'].' EUR</span></p><p class="a"><span class="a">'.$row['Descuento'].' %</span></p></a>'; 

	                   }


	     		
	     		$curso.= 		'<div class="dentro">';
	     		$curso.= 		'<h2 class="text-left">'.$row["Titulo"] .'</h2><hr>';
	     		$curso.= 		'<p class="text-left">' .$row["Descripcion"] .'</p>';
	     		$curso.= 		'<p class="text-left text-primary ">Tiempo estimado '.$row["Duracion"] .' horas</p></div>';
	     		$curso.= '</div>';

	     		echo $curso;

	         	}
	         	// echo $registros;



		}else
		   $funciona = false;
		   // $texto = "Busqueda sin resultados";	
		   // mostrar_busqueda(msgError($texto));
	}



}




function extraerMisCursos(){

	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

	$progreso = "";

	$usu = $_SESSION["email"];

	// echo $usu;

       
	$sql = "SELECT * FROM curso_usuario cu, curso c WHERE cu.Email_Usu = '$usu' AND cu.Id_Curso = c.Id ORDER BY F_inicio DESC";	
	$aux=".";

	// $sql.= 
	$result = $conn->query($sql);

	// var_dump($result);

	if($result->num_rows > 0){ //Hay cursos en la BD

               
     	while($row = mysqli_fetch_assoc($result)){
     		if($row["Lecc_Completadas"]>0)
     			$porcentaje = ($row["Lecc_Completadas"] / $row["Lecciones"])*100;
     		else
     			$porcentaje = 0;

     		if($row["Lecc_Completadas"] < 3)
     			$progreso = "danger";

     		else if($row["Lecc_Completadas"] < 8)
     			$progreso = "warning";

     		else
     			$progreso = "success";


     		$curso = '<div class="cursos margen2">';
     		$curso.= 		'<a href="curso.php?id='.$row["Id"].'"><img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive "></a>';
     		$curso.= 		'<div class="dentro">';
     		$curso.= 			'<h2 class="text-left">'.$row["Titulo"] .'</h2><hr>';
     		$curso.= 			'<div class="progress">';
     		$curso.= 				'<div class="progress-bar progress-bar-'.$progreso.'" role="progressbar" style="width: '.$porcentaje.'%;"></div>';
     		$curso.= 			'</div>';
     		$curso.=            '<p class="text-center text-primary ">Realizadas '.$row["Lecc_Completadas"].' lecciones de '. $row["Lecciones"] .'</p>';
     		$curso.= 		'</div>';
     		$curso.= '</div>';

     		echo $curso;

               // var_dump($row['Descripcion']);

		}
	}
		
}



// function anyadirMisCursos(){

// 	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

// 	$url= $_GET["id"];

// 	$email = $_SESSION["email"];

// 	$fecha = getdate();
// 	$formato = $fecha['year']."-".$fecha['mon']."-".$fecha['mday']." ".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds'];
       
// 	$sql = "INSERT INTO curso_usuario VALUES ('$email', Lecc_Completadas, Calificacion_Test, $url, '$formato')";	
	
// 	mysqli_query($conn,$sql);



// 	$sql = "UPDATE curso_usuario SET F_inicio ='$formato' WHERE Id_Curso = $url AND Email_Usu = '$email' ";	

// 	mysqli_query($conn,$sql);
	          		
// }










function extraerCurso(){

	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

	$url= $_GET["id"];
       
	$sql = "SELECT * FROM curso  WHERE Id = $url";
	$aux = ".";	
	$result = $conn->query($sql);

	if($result->num_rows > 0){ //Hay cursos en la BD

     	while($row = mysqli_fetch_assoc($result)){
     		$precioFinal = $row['Precio'] * ($row['Descuento']*0.01);
			$precioFinal = $row['Precio'] - $precioFinal;
     		if($row['Descuento'] == 0)
     			$la=false;
     		else 
     			$la=true;
			$curso= '<div id="antonioComaMielda"><div class="section" id="navegacion" style="padding-bottom: 0px; padding-top: 0px; margin-left: 200px;">
				        <div class="container ">
				            <div class="row">
				                <div class="col-xs-12 col-sm-9  col-md-9 elemento">
				                    <div class=" col-sm-12 col-md-5 side-corner-tag">';
			if(!$la){
				$curso.=	                        '<img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive">
				                        <p><span class="k">'.$row['Precio'].' EUR</span></p>';
			}else{
				$curso.=	                        '<img src="imagenes/cursos/'.$row["Titulo"].$aux.$row["Foto"].'" class="img-responsive">
				                        <p><span class="desc">'.$row['Precio'].' EUR</span></p> <p><span class="a">'.$row['Descuento'].' %</span></p>   <p><span class="desc2">'.$precioFinal.' EUR</span></p>';
			}
			$curso.=	                    '</div>

				                    <div class="col-md-4  ">';

				                   		$curso.='<h1 class="text-left">'.$row["Titulo"].'</h1><br>';



			$curso.=	                   '<p class="text-success" >'.$row["Descripcion"].'</p>
				                        <div class=" row ">
					                        <div class="col-xs-6 col-sm-6 col-md-6 margen-sup">';

					                        		if(isset($_SESSION['email'])){


				                        				$comprado = 0;
												$usu = $_SESSION["email"];
												$sql2 = "SELECT * FROM curso_usuario cu, curso c WHERE cu.Email_Usu = '$usu' AND cu.Id_Curso = $url";

														$result2=mysqli_query($conn, $sql2);
													    while($row2 = mysqli_fetch_assoc($result2)){
													        $comprado=$row2["Comprado"];
													        break;
													    }









												$result2 = $conn->query($sql2);

												if($result2->num_rows > 0){ //Si existe el curso en mis cursos
													
					                            			$curso.='<a href="dividida/ejercicio.php?id='.$row["Id"].'"  class="btn btn-lg btn-primary"> Continuar </a>';
						                       	
						                       		}else{

						                       			$sql3 = "SELECT * FROM usuario u WHERE u.Email = '$usu'";	
													$result3 = $conn->query($sql3);

													if($result3->num_rows > 0){
														while($row2 = mysqli_fetch_assoc($result3)){

								                       			if($row2['Verificado'] == 0 && !isset($_COOKIE['email_google']) && !isset($_SESSION['fb_access_token']) ){
								                       				$curso.='<a href="dividida/ejercicio.php?id='.$row["Id"].'"  class="btn btn-lg btn-primary disabled"> Empezar </a>';
								                       				$curso.="<p class='verCurso'>*Debes verificar tu cuenta para poder empezar el curso.</p>";

															}else if($row2['Verificado'] == 1 || isset($_COOKIE['email_google']) || isset($_SESSION['fb_access_token'])){
																	$curso.='<a href="dividida/ejercicio.php?id='.$row["Id"].'"  class="btn btn-lg btn-primary"> Empezar </a>';
															}
								                       		}
							                       		}
						                       		}

						                       	}else
						                       		$curso.='<a href="login.php?id='.$row["Id"].'&e=0"  class="btn btn-lg btn-primary" title="Debes iniciar sesión para poder realizar este curso."> Empezar </a>';


			$curso.=						'</div>

					                        <div class="col-xs-6 col-sm-6 col-md-6 margen-sup ">';

					                        $bo=comprobarAddCarrito();
					                        if($bo)
					                        	$la="";
					                        else
					                        	$la="disabled";

										if(!isset($_SESSION['email'])){
					                        		$curso.=	'<form method="POST">
					                            				<input type="submit" class="btn btn-lg btn-primary '.$la.'" value="Añadir Carrito" name="comprar">
															<form>';
					                        }else if($comprado==0){
												$curso.=	'<form method="POST">
					                            				<input type="submit" class="btn btn-lg btn-primary '.$la.'" value="Añadir Carrito" name="comprar">
															<form>';
					                        }


			$curso.=			               '</div> 


					                    </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>';


echo $curso;
$curso="";

readCsv($url);

$curso.=				'<div class="section" style="padding-bottom: 0px;padding-top: 0px; margin-left: 200px;">
				        <div class="container "> 
				            <div class=" elemento verde estrechar col-xs-12 col-sm-9  col-md-9">
				                <div class="col-sm-4 col-md-4 ">
				                  <h3 class="text-info blancoTexto">Si quieres disfrutar del curso completo hazte premium. ¿A qué esperas?</h3>
				                </div>

				                <div class="col-sm-4 col-md-4">
				                  <h3 class="text-info blancoTexto">Tiempo estimado:</h3>
				                    <ul class="lead text-info blancoTexto">
				                      <li>'.$row["Duracion"].' horas</li>
				                    </ul>
				                </div>
				                <div class="col-sm-4 col-md-4 ">
				                  <h3 class="text-info blancoTexto">Dividido en:</h3>
				                    <ul class="lead text-info blancoTexto">
				                      <li>8 lecciones</li>

				                    </ul>
				                </div>
				            </div>
				        </div>
				    </div></div>';

			echo $curso;
			

		}
	}


	// if(isset($_GET["start"])){
	// 	echo "<script> console.log('hola')</script>";
	// }
}









function perfilPOST(){

	global $conn, $genero; //Declaro la var como global para poder acceder a ella dentro de la funcion
       
	$sql = "SELECT * FROM usuario WHERE Email ='". $_SESSION['email']."'";	
	$aux = ".";
	$result = $conn->query($sql);

	if($result->num_rows > 0){ //Hay cursos en la BD

               
     	while($row = mysqli_fetch_assoc($result)){
                    

     		$imprimir = '<div class="col-md-12 ">';
     		$imprimir.= 		'<h3 class="encabezadocurso text-center">Tu perfil,<b> '.$row["Nombre"].'</b></h3><hr class="borrar_linea">';
     		$imprimir.= 	'</div>';
     		$imprimir.= 	'<div class="col-md-6">';

     			if(isset($_SESSION['id'])){
     				$imprimir.='<img src="//graph.facebook.com/'.$_SESSION['id'].'/picture?type=large" class="img-responsive img-thumbnail"  style="max-width: 100">';


     			}else if(isset($_COOKIE['foto_google'])){

					$imprimir.='<img src="'.$_COOKIE['foto_google'].'"  width="1250" class="img-responsive img-thumbnail"  style="max-width: 1000">';

     			}else{

					if($row["Foto"] != NULL)
						$imprimir.='<img src="imagenes/usuarios/'.$row["Email"].$aux.$row["Foto"].'" class="img-responsive img-thumbnail"  style="max-width: 100">';
					
					else
						$imprimir.='<img src="imagenes/usuarios/sinFoto.jpg" class="img-responsive img-thumbnail"  style="max-width: 100">';
				}


     		$imprimir.= 	'</div>';
     		$imprimir.= 	'<div class="col-md-6 ">';
     		$imprimir.=  	'<form role="form" enctype="multipart/form-data" method="POST">';
			$imprimir.= 			'<div class="form-group ">';
			$imprimir.= 				'<label class="control-label " for="exampleInputEmail1">Dirección de correo</label>';
			$imprimir.= 				'<input type="email" class="form-control " id="exampleInputEmail1 " placeholder="'.$row["Email"] .'" disabled>';
			$imprimir.= 			'</div>';

			if(isset($_POST['avanzado'])== NULL){



				if(isset($_SESSION['fb_access_token'])){

					$imprimir.= 				'<label class="control-label">Nombre de usuario</label>';
					$imprimir.= 			'<input type="text" name="nombre" class="form-control " placeholder="'.$_SESSION["nombre"].'" pattern="^[a-zA-Z][a-zA-ZñÑáéíóúÁÉÍÓÚ_\.]{1,20}$" title="Tiene que contener entre [2-20] letras, sin números y espacios">';


				} else if(isset($_COOKIE['email_google'])){

					$imprimir.= 				'<label class="control-label">Nombre de usuario</label>';
					$imprimir.= 			'<input type="text" name="nombre" class="form-control " placeholder="'.$_COOKIE["nombre_google"].'" pattern="^[a-zA-Z][a-zA-ZñÑáéíóúÁÉÍÓÚ_\.]{1,20}$" title="Tiene que contener entre [2-20] letras, sin números y espacios">';

				}else{
					$imprimir.= 				'<label class="control-label">Nombre de usuario</label>';
					$imprimir.= 			'<input type="text" name="nombre" class="form-control " placeholder="'.$row["Nombre"] .'" pattern="^[a-zA-Z][a-zA-ZñÑáéíóúÁÉÍÓÚ_\.]{1,20}$" title="Tiene que contener entre [2-20] letras, sin números y espacios">';
				}
				
					// $imprimir.= 				'<label class="control-label">Nuevos apellidos de usuario</label>';
				// $imprimir.= 				'<input type="text" name="nombre" class="form-control " placeholder='.$row["Apellidos"] .'>';
				// $imprimir.= 			'</div>';
				// $imprimir.= 			'<div class="form-group ">';
				$imprimir.= 				'<label class="control-label" for="exampleInputPassword1 ">Nueva contraseña</label>';
				$imprimir.= 				'<input type="password" name="pass1" id="pass" onkeyup="compararContra();" class="form-control"  placeholder="**********" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo">';
				// $imprimir.= 			'</div>';
				// $imprimir.= 			'<div class="form-group ">';
				$imprimir.= 				'<label class="control-label " for="exampleInputPassword1">Repita contraseña</label>';
				$imprimir.= 				'<input type="password" name="pass2" id="pass2" onkeyup="compararContra();" class="form-control" placeholder="**********" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo">';
				// $imprimir.= 			'</div>';

				$imprimir.= 			'<div class="form-group ">';
				$imprimir.=                   '<input type="hidden" name="MAX_FILE_SIZE" value="2097152">';
				$imprimir.= 				'<label class="control-label " >Foto de perfil (2Mb Máx)</label>';
				$imprimir.= 				'<input type="file" name="imagen" class="form-control">';
				$imprimir.= 			'</div>';

				$imprimir.= 			'<button name="avanzado" class="btn btn-default ">Mostrar perfil avanzado</button>';
				$imprimir.= 			'<button type="submit" name="submit" id="aceptar" class="btn btn-default" style="margin-left:1em">Aceptar</button>';

			}else if(isset($_POST['simple']) == NULL) {

				// $genero = $row["Genero"];
				// echo $genero;
				// echo $genero;
				
				if(isset($_SESSION['fb_access_token'])){

					$imprimir.= 				'<label class="control-label">Apellidos de usuario</label>';
					$imprimir.= 				'<input type="text" name="apellidos" class="form-control " placeholder='.$_SESSION['apellidos'].'>';


				}else if(isset($_COOKIE['apellidos_google'])){
					$imprimir.= 				'<label class="control-label">Apellidos de usuario</label>';
					$imprimir.= 				'<input type="text" name="apellidos" class="form-control " placeholder='.$_COOKIE['apellidos_google'].'>';

     			}else{
					$imprimir.= 				'<label class="control-label">Apellidos de usuario</label>';
					$imprimir.= 				'<input type="text" name="apellidos" class="form-control " placeholder='.$row["Apellidos"] .'>';
				}
				

				$imprimir.= 				'<label class="control-label">Fecha de nacimiento</label>';
				$imprimir.= 				'<input type="date" name="fecha" class="form-control " value='.$row["F_Nac"] .'>';

				$imprimir.= 			'<div class="form-group ">';
				$imprimir.= 				'<label class="control-label">Género</label>';
				$imprimir.= 				'<select name="genero" class="form-control ">';


										if(isset($_SESSION['fb_access_token'])){

											if(strcmp($_SESSION['genero'], "male") == 0){
												$imprimir.= 
												'<option value="1">Hombre</option>
												<option value="0">Mujer</option>';

											}else{
												$imprimir.= 
												'<option value="0">Mujer</option>
												<option value="1">Hombre</option>';
											}


										}else{

											if($row["Genero"] == NULL){
												$imprimir.= 
												'<option value="-1">Sin asignar</option>
												<option value="1">Hombre</option>
												<option value="0">Mujer</option>';

											}else if($row["Genero"] == 1){
												$imprimir.= 
												'<option value="1">Hombre</option>
												<option value="0">Mujer</option>';

											}else{
												$imprimir.= 
												'<option value="0">Mujer</option>
												<option value="1">Hombre</option>';
											}
										}

				$imprimir.= 				'</select>';


				$imprimir.= 			'</div>';






				$imprimir.= 			'<button name="simple" class="btn btn-default ">Mostrar perfil</button>';
				$imprimir.= 			'<button type="submit" name="submit2" class="btn btn-default" style="margin-left:1em">Aceptar</button>';




			}


			
			$imprimir.= 	'</form>';
			$imprimir.= '</div>';
     		
     		echo $imprimir;    

		}
	}
}



function actualizarUsu(){

	global $conn;
	$genero; 
	// echo 'Inicio '.$genero;

	$imgOK=1;

	if(isset($_POST["submit"])){
		if(strcmp($_POST['pass1'],$_POST['pass2'])!=0){
			// msgError("Las contraseñas no coinciden.");

		}if($_POST['pass1'] != NULL && $_POST['pass2'] != NULL){

			$pasEnc=md5($_POST['pass1']);
	       
	          $sql="UPDATE usuario SET Password ='$pasEnc' WHERE Email ='". $_SESSION['email']."'";

		     if(mysqli_query($conn,$sql)){
	               $men = "Tu contraseña se ha actualizado correctamente.";
		          msgExitoPerfil($men);
		     }

		}if($_POST["nombre"] != NULL){

			$nombre= $_POST["nombre"];

			$sql="UPDATE usuario SET Nombre ='$nombre', Perfil_comp = (Perfil_comp+1) WHERE Email ='". $_SESSION['email']."'";

			if(mysqli_query($conn,$sql)){
				$men = "Tu nombre se ha actualizado correctamente.";
	               msgExitoPerfil($men);
	     	}

	     }if(filesize($_FILES['imagen']["tmp_name"])!=0 & filesize($_FILES['imagen']["tmp_name"])!=""){

	     	$imageType = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION); //Con esto me guardo la extension de la foto

	     	$imgOK=comprobarFoto($_SESSION["email"]);

	     	$sql="UPDATE usuario SET Foto = '$imageType', Perfil_comp = (Perfil_comp+1) WHERE Email ='". $_SESSION['email']."'";


	     	//*******************SI HUBO ALGUN PROBLEMA CON LA FOTO NO ACTUALIZO EL USUARIO*****************
	        	if($imgOK==1){
	          	if(mysqli_query($conn,$sql)){
	          		$men = "Tu foto de perfil se ha actualizado correctamente.";
	               	msgExitoPerfil($men);

	          	}else{
	               	if(mysqli_errno($conn) == 1062)//ERROR QUE ME DA EN CASO DE QUE HAYA UN DUPLICADO EN LA ID
	                    	msgErrorCorreo($_SESSION['email']);
	            	}
	        	}
	     }

	}else{


		$sql = "SELECT * FROM usuario WHERE Email ='". $_SESSION['email']."'";	
		$aux = ".";
		$result = $conn->query($sql);

		if($result->num_rows > 0){ //Hay cursos en la BD
               
     		while($row = mysqli_fetch_assoc($result)){
     			$genero = $row["Genero"];
     			$fecha = $row["F_Nac"];

     			// echo $genero;
     		}
     	}


		if($_POST["apellidos"] != NULL){


			$apellido= $_POST["apellidos"];

			$sql="UPDATE usuario SET Apellidos ='$apellido' WHERE Email ='". $_SESSION['email']."'";

			if(mysqli_query($conn,$sql)){
				$men = "Tu apellido se ha actualizado correctamente.";
	               msgExitoPerfil($men);
	     	}


			// echo $_POST["apellidos"];


		}if($_POST["fecha"] != NULL && $_POST["fecha"] != $fecha){

			$fecha = $_POST["fecha"];

			$sql = "UPDATE usuario SET F_Nac = '$fecha' WHERE Email ='". $_SESSION['email']."'";

			if(mysqli_query($conn,$sql)){
				$men = "Tu fecha de nacimiento se ha actualizado correctamente.";
	               msgExitoPerfil($men);
	     	}

			// echo $_POST["fecha"];


		}if($_POST["genero"] != -1 && $_POST["genero"] != $genero){

			$gen = $_POST["genero"];

			$sql = "UPDATE usuario SET Genero = $gen, Perfil_comp = (Perfil_comp+1) WHERE Email ='". $_SESSION['email']."'";

			if(mysqli_query($conn,$sql)){
				$men = "Tu género se ha actualizado correctamente.";
	               msgExitoPerfil($men);
	     	}
		}		
	}
}



function comprobarFoto($correo){

	global $conn;

	$target_dir = "imagenes/usuarios/";
	$target_file = $target_dir . basename($_FILES["imagen"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	//*********PREPARO LA URL PARA SUBIR LA FOTO
	$nombreFoto=$target_dir.$correo.".".$imageFileType;

	//***********COMPRUEBO SI ES UNA IMAGEN O NO
	if(isset($_POST["submit"])) {
	  $check = getimagesize($_FILES["imagen"]["tmp_name"]);
	  if($check == false) {

	      msgError("El archivo seleccionado no es una imágen.");
	      $uploadOk = 0;

	      return $uploadOk;
	  }
	}

	//*********RUTA ANTIGUA****************
	//Lo que hago aqui es buscar a ver si hay ya una imagen subida de ese usuario y borrarla para introducir la nueva imagen

	$sql="SELECT * FROM usuario WHERE Email='$correo'";
	$result = mysqli_query($conn, $sql);
	$ext="";
	while($row = mysqli_fetch_assoc($result)){
	  $ext=$row['Foto'];
	  break;
	}
	// mysqli_close($conn);
	// echo $ext;
	if($ext!=NULL){
	  $antes="imagenes/usuarios/".$correo.'.'.$ext;
	// en caso de que exista el archivo lo borro
	  if (file_exists($antes)) {
	      unlink($antes);
	  }
	}
	//*********FINAL RUTA ANTIGUA FINAL****************

	//************COMPRUEBO QUE EL TAMANO DE LA IMAGEN SEA MENOR QUE 2Mb
	if ($_FILES["imagen"]["size"] > 2097152) {
		// echo "HOLAAAAAAAAA";
	  msgError("La imágen seleccionada pesa más de 2Mb.");
	  $uploadOk = 0;

	  return $uploadOk;
	}
	//********************SOLO SE PERMITEN CIERTOS FORMATOS PARA LA FOTO
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  msgError("La imágen seleccionada tiene que están en formato JPG, PNG, JPEG o GIF.");
	  $uploadOk = 0;

	  return $uploadOk;
	}
	//************ Si ha ocurido algun error no subo la foto
	if ($uploadOk == 0) {
	  return $uploadOk;
	}else{
	  move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreFoto);
	  return $uploadOk;
	}
}



function extraerNoticiaUsu(){

	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

	$usu = $_SESSION["email"];

       
	$sql = "SELECT * FROM noticia_usuario nu, noticia n WHERE nu.Id_Usuario = '$usu' AND nu.Id_Noticia = n.Id ORDER BY n.Id DESC";


	$result = $conn->query($sql);

	// var_dump($result);

	if($result->num_rows > 0){ //Hay cursos en la BD

               
     	while($row = mysqli_fetch_assoc($result)){

     		$id = $row["Id"];
     		$leido = $row['Leido'];

     		$noticia = '<div class="panel panel-default">';
     		$noticia.= 	'<div class="panel-heading">';
     		$noticia.= 		'<h1 class="panel-title">'. $row["Asunto"] .'</h1>';
     		$noticia.= 		'<div class="abrir_sms">';

     		
			$noticia.= '<a class="btn btn-default btn-md" data-toggle="collapse" 
			onclick="llamarArchivo(\'id='.$id.'&usu='.$usu.'&leido='.$leido.'\');"  href="#colapso'.$id.'">';

     		
     		$noticia.= 			'<i class="fa fa-fw -o fa-envelope "></i></a>';
     		$noticia.= 		'</div>';
     		$noticia.= 	'</div>';

     		if($row['Leido'] == 1){
     				$noticia.=	'<div id="colapso'.$row["Id"].'" class="panel-collapse collapse">';
     				// unset($_SESSION['pulsado']);
     		
     		}else{
     			$noticia.=	'<div id="colapso'.$row["Id"].'" class="panel-collapse collapse in">';
     				
     		}

     		$noticia.=		'<div class="panel-body">';
     		$noticia.=  			'<p class="text-justify ">'. $row["Mensaje"].'</p>';
     		$noticia.=		'</div>';		
     		$noticia.=	'</div>';	
     		$noticia.='</div>';	
     	

     		echo $noticia;
		}
	}
}






function extraerNoticia(){

	global $conn; //Declaro la var como global para poder acceder a ella dentro de la funcion

       
	$sql = "SELECT * FROM noticia ORDER BY Id DESC";


	$result = $conn->query($sql);


	if($result->num_rows > 0){ //Hay cursos en la BD

               
     	while($row = mysqli_fetch_assoc($result)){

     		$id = $row["Id"];

     		$noticia = '<div class="panel panel-default">';
     		$noticia.= 	'<div class="panel-heading">';
     		$noticia.= 		'<h1 class="panel-title">'. $row["Asunto"] .'</h1>';
     		$noticia.= 		'<div class="abrir_sms">';

     		


     		$noticia.= '<a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso'.$row["Id"].'">';

     			
     		
     	

     		
     		$noticia.= 			'<i class="fa fa-fw -o fa-envelope "></i></a>';
     		$noticia.= 		'</div>';
     		$noticia.= 	'</div>';

    
     		$noticia.=	'<div id="colapso'.$row["Id"].'" class="panel-collapse collapse in">';
     				

     		$noticia.=		'<div class="panel-body">';
     		$noticia.=  			'<p class="text-justify ">'. $row["Mensaje"].'</p>';
     		$noticia.=		'</div>';		
     		$noticia.=	'</div>';	
     		$noticia.='</div>';	
     	

     		echo $noticia;
		}
	}
}





function mostrarSMS_bienvenida(){

	global $conn;

	$sql = "SELECT * FROM usuario WHERE Email ='". $_SESSION['email']."'";	
	$result = $conn->query($sql);
	
	if($result->num_rows > 0){ 
     	while($row = mysqli_fetch_assoc($result)){

			if($row["Nombre"] == ""){

                	$men = "<b>¡Éxito!</b> Te has registrado en nuestra web. <br>"; 
               	$men.= "<a href='perfil.php' > Ahora puedes completar tu perfil aquí, empezando por indicarnos tu nombre :)</a>"; 
               	msgExitoPerfil($men);
              }

              if($row["Verificado"] == 0 && !isset($_COOKIE['email_google']) && !isset($_SESSION['fb_access_token']) ){

                	$men = "Te hemos mandado al correo un email de verificación, debes verificar tu cuenta si quieres disfrutar de todas las funciones de la página.<br>"; 
               	msgExitoPerfil($men);
              }
         }
    }
}






function redirigirIndex(){

	if($_SESSION == NULL){
		header('Location: /compila/index.php');
	}
}

function redirigirIndex2(){

	if(isset($_SESSION['email'])){
		header('Location: /compila/index.php');
	}
}


function redirigirLogin(){


	// o verificado es false no puede hacer ningun curso.

	if(!isset($_SESSION['email'])){
		header('Location: /compila/login.php');
	}
}


function redirigirVerificado(){

	if(!isset($_GET['usu'])){

		header('Location: /compila/login.php');


	}else{

		$usu = $_GET['usu'];

		global $conn;

		$sql = "SELECT * FROM usuario u WHERE u.Email = '$usu'";	


		$result = $conn->query($sql);

		if($result->num_rows > 0){ 
			while($row = mysqli_fetch_assoc($result)){
				echo $row['Verificado'];

				if($row['Verificado'] == 1)
					header('Location: /compila/login.php');		
			}
		}
	}



	
}



function errorInicio($error){
	// session_start();
	setcookie("error_sesion",$error,time()+3);
	header("Location: http://localhost/compila/login.php");

}



function msgError($msg){ 
	$mensaje='<div class="alert alert-danger">';
	$mensaje.='<strong>¡Error!</strong> '.$msg;
	$mensaje.='</div>';
	echo $mensaje;

}

function msgErrorCorreo($email){

	$mensaje='<div class="alert alert-warning">';
	$mensaje.='<strong>¡Error!</strong> Ya existe un usuario con el email <em>'.$email.' </em> en la BD.';
	$mensaje.='</div>';
	echo $mensaje;
}

function msgExito(){

	$mensaje='<div class="alert alert-success">';
	$mensaje.='<strong>¡Éxito!</strong> Se ha introducido un nuevo usuario a la BD.';
	$mensaje.='</div>';
	echo $mensaje;
}

function msgExitoPerfil($men){

	$mensaje='<div class="alert alert-success">';
	$mensaje.= $men;
	$mensaje.='</div>';
	echo $mensaje;
}




function nohayCurso(){

	global $funciona;

	if($funciona == false){

		echo "<div id='buscar' ><h4> Ningún resultado disponible, quizás te interese alguno de nuestros últimos cursos...</h4></div>";

		cursosIndex();

		// echo "<script> canvas";
		
	}
}


function sendEmail(){

	$destino = $_POST['correo'];

	global $conn;

	$sql = "SELECT u.Email, u.Password FROM usuario u WHERE u.Email = '$destino' ";	


	$result = $conn->query($sql);

	// Enctripto el pass introducido para compararlo con el que hay en la BD
	// $pasEnc= md5($_POST['pass']);

	if($result->num_rows > 0){ //He encontrado un usuario con ese email, EXISTE EN LA BD!
		while($row = mysqli_fetch_assoc($result)){ //Devuelve un array con la info del result

		  

		     $contra = rand();

		     $pasEnc=md5($contra);


		     // El mensaje
			$mensaje = "Hola, <br><br> Aquí tienes tu antigua contraseña, intenta no olvidarla otra vez :) <br> Contraseña: <b>" . $contra . "<b>";

			// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
			$mensaje = wordwrap($mensaje, 70, "\r\n");

			// Enviarlo
			// mail($destino, 'Mi título', $mensaje);


			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: Braineering <info@address.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 

			$sql = "UPDATE usuario SET Password = '$pasEnc' WHERE Email = '$destino' ";	

			if(mysqli_query($conn,$sql)){
	               $men = "Tu contraseña se ha actualizado correctamente.";
		          msgExitoPerfil('Email enviado correctamente');
		     }


			mail($destino , 'Recuperación de contraseña', $mensaje, $headers);
			// header('Location: /compila/login.php');
          }
     

     }else{
     	msgError('El email indicado no existe.');

     }
}








function sendEmailVerification($email){

	$destino = $email;



	  // El mensaje
	$mensaje = "<a href='localhost/compila/verificado.php?usu=".$email."'> Pincha sobre este enlace para verificar tu cuenta</a> <br><br>Al verificar tu cuenta, podrás disfrutar de todas las funciones de nuestra página. Esperamos que disfrutes de Compila! y aprendas con nuestros cursos.<br><br>Un saludo, el equipo <b>Braineering<b>.";

	// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
	$mensaje = wordwrap($mensaje, 70, "\r\n");

	// Enviarlo
	// mail($destino, 'Mi título', $mensaje);


	$headers =  'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'From: Braineering <info@address.com>' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 


	mail($destino , 'Verificación de cuenta', $mensaje, $headers);
}




function userVerification(){

	$usu = $_GET['usu'];


	global $conn;

	$sql = "SELECT * FROM usuario u WHERE u.Email = '$usu' ";	


	$result = $conn->query($sql);

	if($result->num_rows > 0){ 
		while($row = mysqli_fetch_assoc($result)){ 

			$sql2 = "UPDATE usuario SET Verificado = 1 WHERE Email = '$usu' ";	

			mysqli_query($conn,$sql2);
		}
	}
}






function addCarrito(){

	$idCurso="";
	$idCurso.=$_GET['id'].",";
	$array;
	$bla=true;
	$nuevo=true;
	 
	if(!isset($_COOKIE['cantidad_carrito'])){
		setcookie('cantidad_carrito',$idCurso,time()+86400,"/","");
		echo '<script>console.log("Ha entradooooo!!!!")</script>';
	}else{//en caso de que ya tenga una cookie creada
		
		$d=$_COOKIE['cantidad_carrito'];
		$datos=explode(",",$d,-1);

		foreach ($datos as $i => $key){
			if($key==$_GET['id']){
				$nuevo=false;
				echo '<script>console.log("Este curso ya esta dentro!!")</script>';
				//break;
			}
			echo '<script>console.log("'.$key.'")</script>';
		}
		if($nuevo){
			$d.=$idCurso;
		}

		setcookie('cantidad_carrito',$d,time()+86400,"/","");
	}

	echo '<script>window.location.assign("https://localhost/compila/curso.php?id='.$_GET['id'].'")</script>';
}


function mostrarPedido(){
	global $conn;
	$total=0;
	$descuentoTotal=0;
	if(isset($_COOKIE['cantidad_carrito'])){
		//$datos=json_decode($_COOKIE['cantidad_carrito']);
		$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
	}
	
	echo '<script>console.log("Num: '.count($datos).'")</script>';

	$sql="SELECT * FROM curso WHERE id IN (";
	foreach ($datos as $i => $key){
		$sql.=$datos[$i];

		if($i!=(count($datos)-1)){
			$sql.=",";
		}
	}
	$sql.=")";

	for($i=0;$i<count($datos);$i++){
			echo '<script>console.log("'.$datos[$i].'")</script>';
		}

	echo '<script>console.log("'.$sql.'")</script>';


    $result = mysqli_query($conn, $sql);
       
    while($row = mysqli_fetch_assoc($result)) {
    	if($row['Descuento']!=0){
    		$descuentoLocal=round($row['Precio']*((100-$row['Descuento'])/100),2);
    		$descuentoTotal+=round($row['Precio']*(($row['Descuento'])/100),2);
    	}else{
    		$descuentoLocal=$row['Precio'];
    	}
    	$print="";
        $print.='    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="pull-left" href="#"> <img class="media-object img-rounded" src="imagenes/cursos/'.$row["Titulo"].".".$row["Foto"].'" style="width: 85px; height: 85px;"> </a>
                            <div class="media-body" style="padding-left: 4px;">
                                <h4 class="media-heading"><a href="#">'.$row['Titulo'].'</a></h4>
                                <h5 class="media-heading">'.$row['Descripcion'].'</a></h5>
                            </div>
                        </div></td>
                        
                        <td class="col-sm-1 col-md-1 text-center"><strong>'.$row['Precio'].' €</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>'.$row['Descuento'].' %</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>'.$descuentoLocal.' €</strong></td>
                        <td class="col-sm-1 col-md-1 text-center">
                        <button type="button" class="btn btn-danger" onclick="eliminarDelCarro('.$row['Id'].')">
                            <span class="glyphicon glyphicon-remove"></span> Eliminar
                        </button></td>
                    </tr>';

        $total+=$row['Precio'];
        echo $print;
    }
    $IVA=round(($total-$descuentoTotal)*0.21,2);
    $precioFinal=$total-$descuentoTotal+$IVA;
    $str="cursos.php";
    if(isset($_SESSION['email']))
    	$str2="pagoTPV.php";
	else
		$str2="login.php?i=0";

    $print2='</tbody>
                <tfoot>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal<br>Descuento<br>IVA 21%</h5><h3>Total</h3></td>
                        <td class="text-right"><h5><strong>'.$total.' €<br>'.$descuentoTotal.' €<br>'.$IVA.' €</strong></h5><h3>'.$precioFinal.' €</h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <button type="button" class="btn btn-default" onclick="location.href = '."'".$str."'".';">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continuar Comprando
                        </button></td>
                        <td>
                        <button type="button" class="btn btn-success" onclick="location.href = '."'".$str2."'".';">
                            Tramitar Pedido <span class="glyphicon glyphicon-play"></span>
                        </button></td>
                    </tr>
                </tfoot>';
   	echo $print2;
}

function mostrarPedidoTPV(){
	global $conn;

	$total=0;
	$descuentoTotal=0;
	if(isset($_COOKIE['cantidad_carrito'])){
		//$datos=json_decode($_COOKIE['cantidad_carrito']);
		$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
	}
	
	echo '<script>console.log("Num: '.count($datos).'")</script>';

	$sql="SELECT * FROM curso WHERE id IN (";
	foreach ($datos as $i => $key){
		$sql.=$datos[$i];

		if($i!=(count($datos)-1)){
			$sql.=",";
		}
	}
	$sql.=")";

	for($i=0;$i<count($datos);$i++){
			echo '<script>console.log("'.$datos[$i].'")</script>';
		}

	echo '<script>console.log("'.$sql.'")</script>';


    $result = mysqli_query($conn, $sql);
    $print="";
    $descuentoCookie="";
    while($row = mysqli_fetch_assoc($result)) {
    	if($row['Descuento']!=0){
    		$descuentoLocal=round($row['Precio']*((100-$row['Descuento'])/100),2);
    		$descuentoTotal+=round($row['Precio']*(($row['Descuento'])/100),2);
    	}else{    		$descuentoLocal=$row['Precio'];
    	}
    	//$print="";
    	$print.=' 	<div class="form-group pull-right">
				    	<div class="col-sm-3 col-xs-3">
				    		<img class="img-responsive" src="imagenes/cursos/'.$row["Titulo"].".".$row["Foto"].'" />
				    	</div>
				    	<div class="col-sm-6 col-xs-6">
				    		<div class="col-xs-12">'.$row['Titulo'].'</div>
				    	</div>
				    	<div class="col-sm-3 col-xs-3 text-right">
				    		<h6>'.$descuentoLocal.'<span>€</span></h6>
				    	</div>
			    	</div>
			    	<div class="form-group"><hr /></div>';

        $total+=$row['Precio'];
        //echo $print;
    }
    $IVA=round(($total-$descuentoTotal)*0.21,2);
    $precioFinal=$total-$descuentoTotal+$IVA;
    $subTotal=$total-$descuentoTotal;

    $cookie_v="";
    $cookie_v=$subTotal.",".$descuentoTotal.",".$IVA.",".$precioFinal;
    setcookie('detalles_factura', $cookie_v, time() + (86400 * 30), "/","");


    $str="cursos.php";
    $print2='<div class="form-group">
			    <div class="col-xs-12">
			    	<strong>Subtotal</strong>
			    	<div class="pull-right"><span>'.$subTotal.'</span><span>€</span></div>
			    </div>
			    <div class="col-xs-12">
			    	<small>IVA</small>
			    	<div class="pull-right"><span>'.$IVA.'</span><span>€</span></div>
			    </div>
			</div>
			<div class="form-group"><hr /></div>
			<div class="form-group">
				<div class="col-xs-12">
					<strong>Total</strong>
					<div class="pull-right"><span>'.$precioFinal.'</span><span>€</span></div>
				</div>
			</div>';
   	//echo $print2;
   	$pprint=$print.$print2;

   	return $pprint;
}

function tramitarPago(){
	global $conn;
	$datos;
	$precios;
	if(isset($_COOKIE['cantidad_carrito'])){
		//$datos=json_decode($_COOKIE['cantidad_carrito']);
		$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
	}
	if(isset($_COOKIE['detalles_factura'])){
		//$datos=json_decode($_COOKIE['cantidad_carrito']);
		$precios=explode(",",$_COOKIE['detalles_factura']);
	}
	$fecha = date("Y/m/d");
	$hora = date("H:i");
	$usu = $_SESSION['email'];

	//1....LO PRIMERO QUE HAGO ES CREAR UNA NUEVA FACTURA EN LA TABLA *****FACTURA******
	$sql="INSERT INTO factura (Id, Fecha_Creacion, Hora, Subtotal, Descuento, IVA, Total, Usuario) VALUES (NULL, '$fecha','$hora','$precios[0]', '$precios[1]', '$precios[2]','$precios[3]', '$usu')";

	if(mysqli_query($conn,$sql)){
		echo '<script>console.log("Factura Generada Correctamente")</script>';
	}else{
		echo '<script>console.log("Factura no generada: '.mysqli_error($conn).'")</script>';
	}

	//2...RECOJO LA ID MAS GRANDE DE FACTURA---EL ID DE LA FACTURA QUE ACABO DE CREAR
	$sql="SELECT MAX(Id) AS 'maxId' FROM factura";
	$result = mysqli_query($conn, $sql);
	//$idFactura = mysqli_fetch_row($result);
   	while($row = mysqli_fetch_assoc($result)){
   		$idFactura = $row['maxId'];
   	}

   	//3... CREO LAS LINEAS DE FACTURA SEGUN LOS OBJETOS QUE TENGO EN LA CESTA
   	foreach ($datos as $i => $key){
		$sql="INSERT INTO linea_factura (Id_Factura,Id_Curso) VALUES ('$idFactura','$datos[$i]')";
		if(mysqli_query($conn,$sql)){
			echo '<script>console.log("Linea de Factura generada")</script>';
		}else{
			echo '<script>console.log("Linea de factura no generada: '.mysqli_error($conn).'")</script>';
		}
	}
	//4...INTRODUZCO LOS CURSOS A CURSO_USUARIO Y LOS PONGO COMO COMPRADOS
	$d=mktime(00, 00, 00, 01, 01, 1999);
	$fecha=date("Y-m-d H:i:s",$d);
	foreach ($datos as $i => $key){
		$sql="INSERT INTO curso_usuario VALUES ('$usu','0','0','$datos[$i]','$fecha','1')";
		if(mysqli_query($conn,$sql)){
			echo '<script>console.log("Curso-Usuario creado!")</script>';
		}else{
			$sql1="UPDATE curso_usuario SET Comprado = '1' WHERE Email_Usu='$usu' AND Id_Curso='$datos[$i]'";
			if(mysqli_query($conn,$sql1)){
				echo '<script>console.log("Curso-Usuario actualizado(comprado)!")</script>';
			}else{
				echo '<script>console.log("Curso-Usuario no generado: '.mysqli_error($conn).'")</script>';
			}
		}
	}

	 setcookie('detalles_factura', '', time() - 3600, "/","");
	 setcookie('cantidad_carrito', '', time() - 3600, "/","");

	echo '<script>window.location.assign("https://localhost/compila/confirmacionCompra.php")</script>';
}

function cargarLeccionesEnCUrso(){
    global $conn;
    $id = $_GET['id'];
    $usu = $_SESSION['email'];
    $bool1 = true;
    $bool2 = true;
    $sql="SELECT * FROM leccion WHERE Id_Curso = $id";

    //primero obtenemos el numero de lecciones completadas
    $sql2="SELECT Lecc_Completadas FROM curso_usuario WHERE Id_Curso = $id AND Email_Usu = '$usu' ";
    $result2=mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)){
        $comp=$row2["Lecc_Completadas"];
    }
    $fila="";
    $result = mysqli_query($conn, $sql);
    $rowcount=mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
        if($comp>0){//lecciones completadas
        	if($bool1){
        		$fila='<div class="row timeline-movement">
			                <div class="timeline-badge">
			                    <span class="timeline-balloon-date-day glyphicon glyphicon-menu-left bajar-timeline-gly"></span>
			                </div>

			                <div class="col-sm-6  timeline-item">
			                    <div class="row">
			                        <div class="col-sm-4"></div>
			                        <div class="col-sm-7">
			                            <div class="timeline-panel credits">
			                                <ul class="timeline-panel-ul">
			                                    <li><a href="dividida/ejercicio.php?id='.$id.'&leccion='.$row['Orden_Int'].'"><span class="importo">'.$row['Titulo'].'</span></a></li>
			                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-up"></i> Leccion Completada</small></p> </li>
			                                </ul>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>';
        		$bool1=false;
        	}else{
	            $fila='<div class="row timeline-movement">
			                <div class="col-sm-6  timeline-item">
			                    <div class="row">
			                        <div class="col-sm-4"></div>
			                        <div class="col-sm-7">
			                            <div class="timeline-panel credits">
			                                <ul class="timeline-panel-ul">
			                                    <li><a href="dividida/ejercicio.php?id='.$id.'&leccion='.$row['Orden_Int'].'"><span class="importo">'.$row['Titulo'].'</span></a></li>
			                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-up"></i> Leccion Completada</small></p> </li>
			                                </ul>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>';  
		    }
        }else if($comp==0){//leccion actual
        	if($bool1){
        		$fila='<div class="row timeline-movement">
			                <div class="timeline-badge">
			                    <span class="timeline-balloon-date-day glyphicon glyphicon-menu-left bajar-timeline-gly"></span>
			                </div>

			                <div class="row timeline-movement">
				                <div class="col-sm-6  timeline-item">
				                    <div class="row">
				                        <div class="col-sm-4"></div>
				                        <div class="col-sm-7">
				                            <div class="timeline-panel credits">
				                                <ul class="timeline-panel-ul">
				                                    <li><a href="dividida/ejercicio.php?id='.$id.'&leccion='.$row['Orden_Int'].'"><span class="importo">'.$row['Titulo'].'</span></a></li>
				                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-hand-right"></i> Leccion Actual</small></p> </li>
				                                </ul>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>';
        		$bool1=false;
        	}else{
	            $fila='<div class="row timeline-movement">
			                <div class="row timeline-movement">
				                <div class="col-sm-6  timeline-item">
				                    <div class="row">
				                        <div class="col-sm-4"></div>
				                        <div class="col-sm-7">
				                            <div class="timeline-panel credits">
				                                <ul class="timeline-panel-ul">
				                                    <li><a href="dividida/ejercicio.php?id='.$id.'&leccion='.$row['Orden_Int'].'"><span class="importo">'.$row['Titulo'].'</span></a></li>
				                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-hand-right"></i> Leccion Actual</small></p> </li>
				                                </ul>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>';
		    }
        }else{//lecciones no completadas
        	if($bool2){
        		$fila='<div class="row timeline-movement">
			                <div class="timeline-badge">
			                    <span class="timeline-balloon-date-day glyphicon glyphicon-menu-right bajar-timeline-gly"></span>
			                </div>
			                <div class="col-sm-offset-6 col-sm-6  timeline-item">
			                    <div class="row">
			                        <div class="col-sm-offset-1 col-sm-7">
			                            <div class="timeline-panel debits">
			                                <ul class="timeline-panel-ul">
			                                    <li><span class="importo">'.$row['Titulo'].'</span></li>
			                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-down"></i> Leccion Pendiente</small></p> </li>
			                                </ul>
			                            </div>

			                        </div>
			                    </div>
			                </div>
			            </div>';
        		$bool2=false;
        	}else{
	            $fila='<div class="row timeline-movement">
			                <div class="col-sm-offset-6 col-sm-6  timeline-item">
			                    <div class="row">
			                        <div class="col-sm-offset-1 col-sm-7">
			                            <div class="timeline-panel debits">
			                                <ul class="timeline-panel-ul">
			                                    <li><span class="importo">'.$row['Titulo'].'</span></li>
			                                    <li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-down"></i> Leccion Pendiente</small></p> </li>
			                                </ul>
			                            </div>

			                        </div>
			                    </div>
			                </div>
			            </div>';
		    }
        }
        //echo '<script>console.log("'.$comp.'")</script>';
        $comp--;       
        echo $fila;
        $fila="";
    }
}

function cargarLeccionesEnCUrsoSinLoguear(){
    global $conn;
    $bool2 =true;
    $id = $_GET['id'];
    $sql="SELECT * FROM leccion WHERE Id_Curso = $id";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
    	if($bool2){
    		$fila='<div class="row timeline-movement">
			    		<div class="timeline-badge">
			    			<span class="timeline-balloon-date-day glyphicon glyphicon-menu-right bajar-timeline-gly"></span>
			    		</div>
			    		<div class="col-sm-6  timeline-item">
			    			<div class="row">
			    				<div class="col-sm-offset-2 col-sm-7">
			    					<div class="timeline-panel credits">
			    						<ul class="timeline-panel-ul">
			    							<li><span class="importo">'.$row['Titulo'].'</span></li>
			    							<li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-down"></i> Leccion Pendiente</small></p> </li>
			    						</ul>
			    					</div>

			    				</div>
			    			</div>
			    		</div>
			    	</div>';
    	$bool2=false;
    }else{
    	$fila='<div class="row timeline-movement">
			    	<div class="col-sm-6  timeline-item">
			    		<div class="row">
			    			<div class="col-sm-offset-2 col-sm-7">
			    				<div class="timeline-panel credits">
			    					<ul class="timeline-panel-ul">
			    						<li><span class="importo">'.$row['Titulo'].'</span></li>
			    						<li><p><small class="text-muted"><i class="glyphicon glyphicon-thumbs-down"></i> Leccion Pendiente</small></p> </li>
			    					</ul>
			    				</div>

			    			</div>
			    		</div>
			    	</div>
			    </div>';
}    
        echo $fila;
        $fila="";
    }
}

function comprobarAddCarrito(){
	$idCurso=$_GET['id'];
	$lala=true;
	$datos;
	if(isset($_COOKIE['cantidad_carrito'])){
		//$datos=json_decode($_COOKIE['cantidad_carrito']);
		$datos=explode(",",$_COOKIE['cantidad_carrito'],-1);
		foreach ($datos as $i => $key){
		if($datos[$i]==$idCurso)
			$lala=false;
		}
	}

	
	return $lala;
}

function readCsv($id){

	$fila = 1;
	$tots=array();
	$x=0;
	if (($gestor = fopen("OpenData/EPS.csv", "r")) !== FALSE) {
		$asignatura1="";
	    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
	        $numero = count($datos);
	        // echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
	        $fila++;
	       // for ($c=0; $c < $numero; $c++) {
	        	  // echo $datos['tipo'];



	            if (strcmp($asignatura1, $datos[5]) != 0){
	            	/*echo $datos[1].' -- ';
	            	echo $datos[5].'<br>';*/
	            	$tots[] = array($datos[1], $datos[5]);
	            }

			$asignatura1 =  $datos[5];

	    }
	    fclose($gestor);
	    echo '<br><br>';


	    echo '<div class="section" style="padding-top: 0px; padding-bottom: 10px; margin-left: 200px;"   id="contCurso" ><div class="container"><div class="col-xs-12 col-sm-9  col-md-9 elemento" id="letra"><h4 class="text-center" style="padding-bottom: 10px;"> Este curso está relacionado con:</h4>';

	    for ($i=0; $i < 415; $i++) {
	    		//echo $tots[$i][0]." - ".$tots[$i][1].'<br>';

	    		$datos=explode(" ",$tots[$i][1]);
	    		for ($k=0; $k < count($datos); $k++) { 
	    			if($id==27){//C++
	    				if($k==0 && strcmp($datos[$k], "PROGRAMACIÓN") == 0 && strcmp($datos[$k+1], "HIPERMEDIA") != 0){
		    				echo ucfirst(mb_strtolower($tots[$i][0], 'UTF-8'))." - <b id='letra2'>".ucfirst(mb_strtolower($tots[$i][1], 'UTF-8')).'</b><br>';
		    			}else if($k!= 0 && strcmp($datos[$k], "PROGRAMACIÓN") == 0){
		    				echo ucfirst(mb_strtolower($tots[$i][0], 'UTF-8'))." - <b id='letra2'>".ucfirst(mb_strtolower($tots[$i][1], 'UTF-8')).'</b><br>';
		    			}
	    			}else if($id==17){//NodeJs
		    			if(strcmp($datos[$k], "REDES") == 0 || strcmp($datos[$k], "BASADOS") == 0){
		    				echo ucfirst(mb_strtolower($tots[$i][0], 'UTF-8'))." - <b id='letra2'>".ucfirst(mb_strtolower($tots[$i][1], 'UTF-8')).'</b><br>';

		    			}
	    			}else{
		    			if(strcmp($datos[$k], "HIPERMEDIA") == 0 || strcmp($datos[$k], "WEB") == 0){
		    				echo ucfirst(mb_strtolower($tots[$i][0], 'UTF-8'))." - <b id='letra2'>".ucfirst(mb_strtolower($tots[$i][1], 'UTF-8')).'</b><br>';
		    			}
	    			}
	    		}
	    }
	}

	echo '</div></div></div>';
}

?>