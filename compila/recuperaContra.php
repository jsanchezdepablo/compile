<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Recuperar contraseña</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/javascript.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="javascript/miJava.js"></script>
  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css\estilos.css" rel="stylesheet" type="text/css">
  <?php require_once 'funcionesPhp.php'; ?>
</head>


<body> 
  <div id="contenido">
    <header>
        <?php 
                  
          comprobarSesion(7);
          redirigirIndex2();

          if (isset($_GET['salir']))
              eliminarSesion();
                    
        ?>
    </header>


<?php 

  if(isset($_POST['procesar'])){
    sendEmail();
  }

  if(isset($_POST['volver'])){
    header('Location: /compila/login.php');
  }



?>





      <div id="id01">
          
          <form class="modal-content animate"  method="POST">
              <div class="imgcontainer">
                <h3>Recupera tu contaseña</h3>
                <br>
              </div>

              <div class="containerModal">


                   <label><b>Correo Electrónico</b></label>
                   
                   <?php 

                    if(!isset($_POST['procesar'])){
                      echo "<input type='email' placeholder='Introduce el Correo' name='correo' required><br><br>";

                      echo "<input type='submit' name='procesar' class='btn btn-primary pull-right' value='Recuperar'>";

                    }else{
                       echo "<input type='email' placeholder='Introduce el Correo' name='correo'><br><br>";
                       
                      echo "<input type='submit' name='volver' class='btn btn-primary pull-right' value='Volver login'>";
                    }


                   ?>
                   
                  <div class="clearfix"></div>
              </div>
          </form>
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
  </body>
</html>