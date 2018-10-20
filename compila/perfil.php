<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Perfil</title>
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
        
          redirigirIndex();

          comprobarSesion(4);

          if (isset($_GET['salir']))
              eliminarSesion();       
        ?>
    </header>


      <div class="section " id="navegacion ">
          <div class="container ">
              <div class="row ">



                <?php 

                  if(isset($_POST["submit"]) || isset($_POST["submit2"]))
                    actualizarUsu();



                  perfilPOST();

                  

                ?>
                  
              
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
</body>
</html>