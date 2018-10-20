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
  <link href="css\estilos.css" rel="stylesheet" type="text/css">

</head>

<body>

  <div id="contenido">
  <header>
      <?php 
      
        comprobarSesion(23);

        if (isset($_GET['salir']))
            eliminarSesion();
      ?> 
  </header>




<div class="container">
    <br><br>
    <!-- <h3 class="encabezadocurso text-center">Carrito de compra</h3><hr class="borrar_linea"> -->

    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Descuento</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(isset($_COOKIE['cantidad_carrito'])){
                            mostrarPedido();
                        }
                    ?>
            </table>
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

  <script>
function eliminarDelCarro(id) {

    var value =getCookie('cantidad_carrito');
    var parts = value.split(",");
    var nuevaCookie="";
    for (var i = 0; i < parts.length-1; i++) {
        if(parts[i]==id){
            
        }else{
            nuevaCookie=nuevaCookie.concat(parts[i]);
            nuevaCookie=nuevaCookie.concat(",");
        }
    }
    
    var d = new Date();
    d.setTime(d.getTime() + (10*24*60*60*1000));
    var expira = d.toUTCString();

    document.cookie = "cantidad_carrito="+nuevaCookie+"; expires="+expira+"; path=/;";

    if(parts.length==2){
        document.cookie = "cantidad_carrito=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.assign("https://localhost/compila/cursos.php");
    }else{
        window.location.assign("https://localhost/compila/carrito.php");
    }   
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
</script>
</html>
