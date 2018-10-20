<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Mis cursos</title>
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
          
          comprobarSesion(5); 

          if (isset($_GET['salir']))
              eliminarSesion();              
        ?>


    </header>


    <div class="section " id="navegacion ">
        <div class="container ">
            <div class="row ">
              <div class="col-md-12 ">

              <?php
                mostrarSMS_bienvenida();
              ?>

              </div>
            </div>

            <div class="row flex">


              <?php 


                extraerMisCursos();


              ?>

                <!-- <div class="cursos margen2">
                  <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                  <div class="dentro">
                  <h2 class="text-left">Gráficos Básicos</h2>
                  <hr>
                  <h3 class="text-left">Progreso</h3>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%;">5/5</div>
                    </div>
                    <i class="fa fa-3x fa-check fa-fw pull-right text-success"></i></div>
                </div>


                <div class="cursos margen2">
                  <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                  <div class="dentro">
                  <h2 class="text-left">Gráficos Básicos</h2>
                  <hr>
                  <h3 class="text-left">Progreso</h3>
                  <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width: 60%;">3/5</div>
                  </div>
                  <i class="-o fa fa-3x fa-fw fa-leanpub pull-right text-warning"></i></div>
                </div>

                <div class="cursos margen2">
                  <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                  <div class="dentro">
                  <h2 class="text-left">Gráficos Básicos</h2>
                  <hr>
                  <h3 class="text-left">Progreso</h3>
                  <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 20%;">1/5</div>
                  </div>
                  <i class="-o fa fa-3x fa-bullhorn fa-fw pull-right text-danger"></i></div>
                </div>

                <div class="cursos margen2">
                  <a href="curso.html"><img src="imagenes\html.png" class="img-responsive "></a>
                  <div class="dentro">
                  <h2 class="text-left">Gráficos Básicos</h2>
                  <hr>
                  <h3 class="text-left">Progreso</h3>
                  <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width: 60%;">3/5</div>
                  </div>
                  <i class="-o fa fa-3x fa-fw fa-leanpub pull-right text-warning"></i></div>
                </div>
                 -->
              </div>
          </div>
      </div>

    </div>


  



       <footer class="section section-primary">
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