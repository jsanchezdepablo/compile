<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Noticias</title>
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
        
          comprobarSesion(3);

          if (isset($_GET['salir']))
              eliminarSesion();        
        ?>  
    </header>



    <div id="login"></div>  
    <div id="registro"></div> 

    <br><br><br>
    <div class="section " id="navegacion ">
        <div class="container ">
            

            <?php 

            if(isset($_SESSION['email']))
                extraerNoticiaUsu();

            else
                extraerNoticia();


            ?>

                         
            <!-- <div class="panel panel-default">
                <div class="panel-heading">
                  <h1 class="panel-title">Titulo noticia</h1>
                      <div class="abrir_sms">
                          <a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso1">
                          <i class="fa fa-fw -o fa-envelope "></i>&nbsp;No leido</a>
                      </div>
                </div>
                <div id="colapso1" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p class="text-justify ">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor
                          incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                          nostrud. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod
                          tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud.
                      </p>
                  </div>

                </div>

            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                  <h1 class="panel-title">Titulo noticia</h1>
                      <div class="abrir_sms">
                          <a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso2">
                          <i class="fa fa-fw -o fa-envelope "></i>&nbsp;No leido</a>
                      </div>
                </div>
                <div id="colapso2" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p class="text-justify ">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor
                          incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                          nostrud. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod
                          tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud.
                      </p>
                  </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                  <h1 class="panel-title">Titulo noticia</h1>
                      <div class="abrir_sms">
                          <a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso3">
                          <i class="fa fa-fw -o fa-envelope "></i>&nbsp;No leido</a>
                      </div>
                </div>
                <div id="colapso3" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p class="text-justify ">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor
                          incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                          nostrud. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod
                          tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud.
                      </p>
                  </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                  <h1 class="panel-title">Titulo noticia</h1>
                      <div class="abrir_sms">
                          <a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso4">
                          <i class="fa fa-fw -o fa-envelope "></i>&nbsp;No leido</a>
                      </div>
                </div>
                <div id="colapso4" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p class="text-justify ">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor
                          incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                          nostrud. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod
                          tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud.
                      </p>
                  </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                  <h1 class="panel-title">Titulo noticia</h1>
                      <div class="abrir_sms">
                          <a class="btn btn-default btn-md" data-toggle="collapse" href="#colapso5">
                          <i class="fa fa-fw -o fa-envelope "></i>&nbsp;No leido</a>
                      </div>
                </div>
                <div id="colapso5" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p class="text-justify ">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor
                          incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                          nostrud. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod
                          tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud.
                      </p>
                  </div>
                </div>
            </div>
   -->

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
      <script type="text/javascript ">
          //Funcion boton empezar
            $("#boton ").click(function() {
              $('html, body').animate({
                  scrollTop: $("#navegacion ").offset().top
              }, 1000);
            });
      </script>

  </body>
</html>