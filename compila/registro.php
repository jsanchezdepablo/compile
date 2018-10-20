<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Registro</title>
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
                  
          comprobarSesion(6);
          redirigirIndex2();

          if (isset($_GET['salir']))
              eliminarSesion();
                    
        ?>
    </header>





    <div id="id02">
          <form class="modal-content animate form-horizontal"  method="POST" >
            
       <div class="imgcontainer">
        
         <h2>Registro</h2>

       </div>

            <div class="containerModal">

             <?php 
                if(isset($_POST['procesar'])){ 
                    addUsu();

                    if($funciona == true)
                      loginUsu();
                } 
              ?>


               <label for="email">Correo Electrónico</label>
               <input type="email" id="email" name="correo" placeholder="Correo Electrónico" class="form-control" required="">

               <label for="contrasena">Contraseña</label>
               <input type="password"  name="pass" id="pass" placeholder="Contraseña" class="form-control" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo" onkeyup="compararContra();" required="">

               <label for="contrasena2">Repite Contraseña</label>
               <input type="password" name="pass2" id="pass2" placeholder="Repite Contraseña" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo" class="form-control" required="" onkeyup="compararContra();">

                <div class="form-group">
                  <div class="col-sm-12 col-sm-offset-0">
                    <div class="checkbox">
                        <label>
                             <input type="checkbox" required="" > Acepto los <a href="#">términos y condiciones</a>
                        </label>
                        
                    </div>
                  </div>
                </div> 
               <input type="submit" name="procesar" id="aceptar" class="btn btn-primary btn-block buttonLog2" value="Registrarse">
               <div class="form-group">
                  <span class="psw" style="margin-right: 1em;">¿Ya estás registrado? <a href="login.php">Inicia sesión</a></span>
               </div>
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