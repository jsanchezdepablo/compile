<?php 
    require_once 'funcionesPhp.php';
?>

<!DOCTYPE html>
<html lang="es">

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
  <link href="css/estilos.css" rel="stylesheet" type="text/css">

</head>
<body>

    <div id="contenido">
        <header>
          <?php   
            comprobarSesion(13);
            if (isset($_GET['salir']))
                eliminarSesion();
        ?> 
        </header>

        <div class="container"><br>


            <div class="container">
                <div class="row text-center">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h2 style="color:#0fad00">Éxito</h2><br>
                        <img src="https://vignette2.wikia.nocookie.net/spongebob/images/f/f4/Check-icon.png/revision/latest?cb=20121121053456">
          
                        <h3>Señor, <?php echo $_SESSION['nombre']." ".$_SESSION['apellidos']  ?></h3><br>
                        <p style="font-size:20px;color:#5C5C5C;">Gracias por su compra en <em>Compila.es</em>. Esperemos que disfrute y aprenda de los cursos que haya comprado. A continuación puede generar una factura del pedido que acaba de realizar.</p><br>
                        <a href="facturaPDF/factura.php" class="btn btn-info btn-lg" target="_blank">Generar Factura</a><br><br>
                    </div>
                    
                </div>
            </div>
        </div>

    
</div>

    <footer class="section section-primary ">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                  <h1>Grupo Braineering</h1>
                  <p>2017 © Programming Cloud
                    <br>Todos los derechos reservados.</p>
                </div>
                <div class="col-sm-6">
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
