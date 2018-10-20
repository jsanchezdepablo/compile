<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Todos los cursos</title>
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
      
        comprobarSesion(2);



        // if (isset($_GET['salir']))
        //     eliminarSesion();


        
          
      ?>  
  </header>





  <div class="section " id="navegacion ">
      <div class="container ">
          <div class="row ">
            <div class="col-md-12">
                <form method="POST">

                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="search" class="form-control input-lg" name="buscar" placeholder="Nombre del curso" autofocus pattern="^[a-zA-Z][a-zA-Z0-9- _\.]{0,20}$">
                            <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg" name="buscador" type="submit">
                                      <i class="glyphicon glyphicon-search"></i>
                                  </button>
                            </span>
                        </div>
                    </div>
                </form>
                  <!--   <h3 class="encabezadocurso text-center">Todos los cursos</h3><hr class="borrar_linea"> -->
            </div>
    
          </div>

          
          <div class="row flex" style="margin-top: 1em;">

            <?php 

                extraerCursos();
                nohayCurso();



            ?>

              <!-- <div class="cursos margen2">
                <a href="curso.php"><img src="imagenes\html.png" class="img-responsive "></a>
                <div class="dentro">
                <h2 class="text-left">Gráficos Básicos</h2>
                <hr>
                <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
              </div>

              <div class="cursos margen2">
                <a href="curso.php"><img src="imagenes\html.png" class="img-responsive "></a>
                <div class="dentro">
                <h2 class="text-left">Gráficos Básicos</h2>
                <hr>
                <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
              </div>

              <div class="cursos margen2">
                <a href="curso.php"><img src="imagenes\html.png" class="img-responsive "></a>
                <div class="dentro">
                <h2 class="text-left">Gráficos Básicos</h2>
                <hr>
                <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisici elit,sed eiusmod tempor incidunt ut labore et dolore magna aliqua.</p>
                <p class="text-left text-primary ">Tiempo estimado 3 horas.</p></div>
              </div>

              <div class="cursos margen2">
                <a href="curso.php"><img src="imagenes\html.png" class="img-responsive "></a>
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