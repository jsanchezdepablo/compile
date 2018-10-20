<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Inicia sesión</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-signin-scope" content="profile email">
  <meta name="google-signin-client_id" content="939240033950-geua5mfvqrpunv4d9helg4jgtno75r48.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/javascript.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="bootstrap/js/bootstrap-social.css"></script> -->
  <script type="text/javascript" src="javascript/miJava.js"></script>
  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css\estilos.css" rel="stylesheet" type="text/css">
  <?php 
    require_once 'funcionesPhp.php'; 
    require 'facebook/app/fb_init.php';
  ?>
</head>


<body> 



  <div id="contenido">
    <header>
       <?php 
                  
          comprobarSesion(7);

          redirigirIndex2();

          if (isset($_GET['salir']))
              eliminarSesion();







               if(isset($_COOKIE['email_google'])){

                  if(!isset($_SESSION['email']))
                      header('Location: /compila/index.php');

                  $_SESSION['email'] = $_COOKIE['email_google'];
                  $_SESSION['nombre'] = $_COOKIE['nombre_google'];
                  $_SESSION['apellidos'] = $_COOKIE['apellidos_google'];
                }

              
      ?>
    </header>






      <div id="id01">
          
          <form class="modal-content animate"  method="POST">
              <div class="imgcontainer">
                <?php 
                if(isset($_GET['i']))
                     echo '<h2 class="naranja">¡Estás a un solo paso de poder comprar el curso!</h2>';
                else if(isset($_GET['e']))
                         echo '<h2 class="naranja">¡Estás a un solo paso de poder empezar el curso!</h2>';
                else
                    echo '<h2>Login</h2>';
              ?>
              </div>

              <div class="containerModal">


              <?php 

                if(isset($_POST['procesar'])){ 
                 // echo '<script>console.log("'.$_POST["recuerda"].'")</script>';
                    loginUsu();
                } 

                if(isset($_POST['recuerda'])){ 
                    echo '<script>console.log("FUNCIONA!")</script>';
                    recuerdame();
                }

               

                



                if(isset($_COOKIE['error_sesion'])){
                    echo ' <div class="alert alert-danger">';
                        echo '<strong>¡Error! </strong>'.$_COOKIE['error_sesion'];
                        setcookie("error_sesion", "", time()-3600);
                    echo '</div>';
                }
              ?>


      

                   <label><b>Correo Electrónico</b></label>
                   <input type="email" placeholder="Introduce el Correo" name="correo" required="" >

                   <label><b>Contraseña</b></label>
                   <input type="password" placeholder="Introduce la Contraseña" name="pass" required="">
                     
                   <input type="checkbox"  name="recuerda" id="recuerda" value="Yes"> Recuérdame

                   <input type="submit" name="procesar" class="buttonLog" value="Iniciar Sesión">

                     
                  


                   
                  
                    <span>¿Aún no estás <a href="registro.php">registrado</a>?</span>
                    <span class="psw">¿Has olvidado tu <a href="recuperaContra.php">contraseña</a>?</span>
                   
                   
                    <hr>

                    <!-- <a class="btn btn-block btn-social btn-facebook">
                        <span class="fa fa-facebook"></span> Iniciar Sesión con Facebook
                    </a> -->
                    <div id="colocaAntuan">

                    <?php  


                        $helper = $fb->getRedirectLoginHelper();

                        $permissions = []; // Optional permissions
                        $loginUrl = $helper->getLoginUrl('http://localhost/compila/login_callback.php', $permissions);
                        
                        $_SESSION['actualizado'] = 0;
                        
                        
                        // echo '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($loginUrl) . '">
                        // <span class="fa fa-facebook"></span> Iniciar sesión con Facebook</a>';

                        echo '<a href="' . htmlspecialchars($loginUrl) . '"><img src="imagenes/face.png" width="114px" style="margin-right: 2em"></a>';
                    
                    ?>
                      


                 <!--    <a class="btn btn-block btn-social btn-google" data-onsuccess="onSignIn" data-theme="dark">
                      <span class="fa fa-google"></span> Iniciar Sesión con Google
                    </a>
 -->

                    <div class="g-signin2 padding" data-onsuccess="onSignIn" data-theme="dark"></div>



                    <script>
                      function onSignIn(googleUser) {
                              // Useful data for your client-side scripts:
                              var profile = googleUser.getBasicProfile();
                              console.log("ID: " + profile.getId()); // Don't send this directly to your server!
                              console.log('Full Name: ' + profile.getName());
                              console.log('Given Name: ' + profile.getGivenName());
                              console.log('Family Name: ' + profile.getFamilyName());
                              console.log("Image URL: " + profile.getImageUrl());
                              console.log("Email: " + profile.getEmail());

                              // The ID token you need to pass to your backend:
                              var id_token = googleUser.getAuthResponse().id_token;
                              console.log("ID Token: " + id_token);
                         

                              //CREO COOKIES PARA LLEVAR LAS VARIABLES A PHP
                              var d = new Date();
                              d.setTime(d.getTime() + (10*24*60*60*1000));
                              var expira = d.toUTCString();


                              document.cookie = "email_google="+profile.getEmail()+"; expires="+expira+"; path=/;";
                              document.cookie = "foto_google="+profile.getImageUrl()+"; expires="+expira+"; path=/;";
                              document.cookie = "apellidos_google="+profile.getFamilyName()+"; expires="+expira+"; path=/;";
                              document.cookie = "nombre_google="+profile.getGivenName()+"; expires="+expira+"; path=/;";


                              location.reload();
                              


                      };


                      

                    </script>


              </div>
          </form>
      </div>

    </div>




      <?php






        
      ?>



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
  </body>
</html>