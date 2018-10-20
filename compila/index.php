<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Inicio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/javascript.js"></script>
  <script type="text/javascript" src="javascript/miJava.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="bootstrap/font-awesome/css/font-awesome.min.css" >
  <link rel="stylesheet" type="text/css" href="css\estilos.css" >
  <?php 
    require_once 'funcionesPhp.php'; 
    require 'facebook/app/fb_init.php';
  ?>
</head>


<body> 
    <header>
      <?php 
          global $actualizado;

        
          comprobarSesion(1);

          if (isset($_GET['salir']))
              eliminarSesion(); 



          if(isset($_SESSION['fb_access_token'])){
            if($_SESSION['actualizado'] == 0 ){

                $_SESSION['actualizado'] = 1;
                header('Location: http://localhost/compila/index.php'); 

            }
          }




    if(isset($_SESSION['fb_access_token'])){

      try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,first_name,last_name,email,birthday,picture, gender', $_SESSION['fb_access_token']);
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }

      $user = $response->getGraphUser();


      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = "jsdp93@gmail.com";
      $_SESSION['nombre'] = $user['first_name'];
      $_SESSION['apellidos'] = $user['last_name'];
      $_SESSION['fotoFace'] = $user['picture'];
      $_SESSION['genero'] = $user['gender'];

      // var_dump($_SESSION['fotoFace']);

      
      // echo $user['id'];

      // echo $_SESSION['genero'];


      addUsuFace($_SESSION['email'], $user['first_name'], $user['last_name']);




      // loginUsuFace($user['email']);

      //***************************************TENGO QUE LLAMAR A LA FUNCION DESDE OTRO LADO, NO DESDE LOGIN Y GUARDAR LOS DATOS EN VARIBALES DE SESION PARA COMPLETAR EL PERFIL**************************

  //     echo 'Name: ' . $user['first_name'] . '<br>';
  //     // OR
  //     // echo 'Name: ' . $user->getName();
  //     echo 'Email: ' . $user->getEmail(). '<br>';

  //     echo 'Id: ' . $_SESSION['id']. '<br>';

  // echo '<img src="//graph.facebook.com/'.$user->getId().'/picture"';

  //     echo $user;

      
      

      // echo '<br> <a href="logout.php"> SALIR</a>';

      // echo $_SESSION['fb_access_token'];


    }      


    ?> 


   <!--  // $googleClient = new Google_Client();
    // $auth = new GoogleAuth($googleClient);

    // if($auth->checkRedirectCode()){
    //   //die($_GET['code']);
    //   header('Location: index.php');
    // }


    // if(!$auth->isLoggedIn()): -->






       


    </header>

    


    
      <div class="cover">
          <div class="background-image-fixed cover-image" style="background-image: url('imagenes/portada.jpg');"></div>
          <div class="container">
              <div class="row">
                  <div class="col-md-12 text-center">
                      <h1>Compila con Pila!</h1>
                      <p>Tu aula online para
                          <span class="resaltado">aprender a programar</span>
                      </p>
                      <br>
                      <br>

                      <?php 
                        comprobarSesion2();

                      ?>
                      
                  </div>
              </div>
          </div>
      </div>

          


      <div class="section " id="navegacion ">
          <div class="container ">

  	      	<div class="row ">
  	              <div class="col-md-12 "><h1 class="text-center encabezadocurso">Sobre nosotros</h1>
  	                	<p class="lead text-center ">Somos un grupo de estudiantes de 4º de Ingeniería Multimedia y nos hacemos llamar Braineering. Para la realización del ABP, nos hemos propuesto crear una página web donde se puede aprender a programar de una manera interactiva y sencilla. Nosotros somos:</p>


  		               <div class="row flex">
  			              <div class="cursos margen2">
  			                <img src="imagenes/creadores/jesus.jpg" class="img-responsive ">
  			                <div class="dentro">
  				                <h2 class="text-center">Jesús Sánchez</h2>    
  		               	  </div>
  		               	</div>

  		               	<div class="cursos margen2">
  			                <img src="imagenes/creadores/valen.jpg" class="img-responsive ">
  			                <div class="dentro">
  				                <h2 class="text-center">Valentín Ututui</h2>    
  		               	  </div>
  		               	</div>

  		               	<div class="cursos margen2">
  			                <img src="imagenes/creadores/antonio.jpg" class="img-responsive ">
  			                <div class="dentro">
  				                <h2 class="text-center">Antonio Candela</h2>    
  		               	  </div>
  		               	</div>
  		               </div>
  	              </div>
  	  	    </div>


              <div class="row bajar">
                <div class="col-md-12 ">
                  <h1 class="text-center encabezadocurso ">Últimos cursos</h1>
                </div>
              </div>
                  

              <div class="section">
                  <div class="row flex">

                    <?php 
                      cursosIndex();

                    ?>
                      
                      <!-- <div class="cursos margen2">
                        <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                        <div class="dentro">
                        <h2 class="text-left">Gráficos Básicos</h2>
                        <hr>
                        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                        <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
                      </div>

                      <div class="cursos margen2">
                        <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                        <div class="dentro">
                        <h2 class="text-left">Gráficos Básicos</h2>
                        <hr>
                        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                        <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
                      </div>

                      <div class="cursos margen2">
                        <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                        <div class="dentro">
                        <h2 class="text-left">Gráficos Básicos</h2>
                        <hr>
                        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                        <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
                      </div>

                      <div class="cursos margen2">
                        <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                        <div class="dentro">
                        <h2 class="text-left">Gráficos Básicos</h2>
                        <hr>
                        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                        <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
                      </div> -->
                  </div>
              </div>
          
          </div>
      </div>

    

     <footer class="section section-primary ">
          <div class="container ">
              <div class="row ">
                  <div class="col-sm-6 ">
                      <h1>Grupo Braineering</h1>
                      <p>2017 © Programming Cloud
                          <br>Todos los derechos reservados.</p>
                  </div>
                  <div class="col-sm-6 ">
                      <p class="text-info text-right ">
                          <br>
                          <br>
                      </p>
                      <div class="row ">
                          <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left ">
                              <a href="# "><i class="fa fa-3x fa-fw fa-instagram text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-twitter text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-facebook text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-github text-inverse "></i></a>
                          </div>
                      </div>
                      <div class="row ">
                          <div class="col-md-12 hidden-xs text-right ">
                              <a href="# "><i class="fa fa-3x fa-fw fa-instagram text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-twitter text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-facebook text-inverse "></i></a>
                              <a href="# "><i class="fa fa-3x fa-fw fa-github text-inverse "></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </footer>
      <!-- <script type="text/javascript ">
          //Funcion boton empezar
            $("#boton ").click(function() {
              $('html, body').animate({
                  scrollTop: $("#navegacion ").offset().top
              }, 1000);
            });
      </script> -->

  </body>
</html>