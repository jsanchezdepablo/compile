<!DOCTYPE html>
<html lang="es">



<?php 
  require_once 'funcionesPhp.php';

  
if(isset($_POST['comprar'])) 
    addCarrito();


?>




<head>
  <meta name="description">
  <title>Empezar curso</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/javascript.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="javascript/miJava.js"></script>
  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css\estilos.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

</head>


<body>

  <div id="contenido">
  <header>
      <?php 
      
        comprobarSesion(2);

        if (isset($_GET['salir']))
            eliminarSesion(); 




      ?> 
  </header>



    <?php 
      extraerCurso();
    ?>

    <div class="section section-margin">
    <div class="container">
        <div class="row">
            <?php
            if(isset($_SESSION['email'])) 
                echo '<div id="timeline">';
            else
                echo '<div id="timeline2">';
            ?>
            
                <div class="row timeline-movement timeline-movement-top">
                    <div class="timeline-badge timeline-future-movement">
                        <a href="#" class="disabled" disabled>
                            <span class="glyphicon glyphicon-education"></span>
                        </a>
                    </div>
                </div>
                <?php
                    if(isset($_SESSION['email'])) 
                        cargarLeccionesEnCUrso();  
                    else
                        cargarLeccionesEnCUrsoSinLoguear();
                ?>

            </div> <!--END TIMELINE 2.0 -->
        </div><!--END DIV CONTAINER-->
    </div> 
</div><br><br><br><br>







    
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