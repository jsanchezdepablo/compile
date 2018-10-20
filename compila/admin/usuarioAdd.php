<!doctype html>
<?php include '/php/comprobarUsu.php'; ?>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Panel ADM - Compila</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.11.1.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">

</head>
<body class=" theme-blue">
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
            color: #fff;
        }
    </style>

    <!--Incluyo la barra TOP y el NAV LEFT-->
    <?php include '/php/navTop.php'; ?>
    
    <?php include '/php/navSide.php'; 
        activado(4);
    ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">Añadir Usuario</h1>
            <ul class="breadcrumb">
                <li><a href="usuarios.html">Usuarios</a> </li>
                <li class="active">Añadir Usuario</li>
            </ul>
        </div>
        <div class="main-content">
        <?php
                if(isset($_POST['submit'])){
                    addUsuario();
                }
        ?>
            <?php  

            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Se ha introducido un nuevo usuario a la Base de Datos.';
                $mensaje.='</div>';
                echo $mensaje;
            }
            function msgErrorCorreo($email){
                $mensaje='<div class="alert alert-warning">';
                $mensaje.='<strong>Error!</strong> Ya existe un usuario con el email <em>'.$email.' </em> en la Base de Datos.';
                $mensaje.='</div>';
                echo $mensaje;
            }
            function msgError($msg){
                 $mensaje='<div class="alert alert-danger">';
                $mensaje.='<strong>Error!</strong> '.$msg;
                $mensaje.='</div>';
                echo $mensaje;
            }
                
            ?>
            <div class="row">
                <div class="col-md-4">
                <br>
                    <form id="tab" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group" action="" method="POST">
                            <label>Correo Electrónico</label>
                            <input type="email" name="correo" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" name="apelli" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="pass" value="" class="form-control" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo" required>
                        </div>
                        <div class="form-group">
                            <label>Repite Contraseña</label>
                            <input type="password" name="pass2" value="" class="form-control" pattern="(?=.*\d)(?=.*[A-Za-z]).{6,}" title="Tiene que contener un número, una letra y 6 carácteres como mínimo" required>
                        </div>
                        <div class="form-group">
                            <label>Imagen Perfil(2Mb Máx)</label>
                            <input type="file" name="imagen" id="imagen" value="" class="form-control">
                        </div>
                        <br>
                        <div class="[ form-group ]">
                            <input type="checkbox" name="admin" value="1" id="fancy-checkbox-default" autocomplete="off" />
                            <div class="[ btn-group ]">
                                <label for="fancy-checkbox-default" class="[ btn btn-default ]">
                                    <span class="[ glyphicon glyphicon-ok ]"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-default" class="[ btn btn-default active ]">
                                    Usuario Tipo Administrador
                                </label>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary"value="Añadir Usuario">
                            <input type="button" class="btn btn-danger" onclick="limpiarForm()" value="Limpiar Formulario">
                        </div>
                    </form>
                </div>
            </div>


            <script>
                function limpiarForm(){
                    document.getElementById("tab").reset();
                }
            </script>

            
            <footer>
                <hr>
                <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                <p class="pull-right"></p>
                <p>© 2017 <a href="http://www.compila.es" target="_blank">Compila!</a></p>
            </footer>
        </div> <!--END CONTENIDO PRINCIPAL -->
    </div>

    <!-- *****Función que me hace el animado del sidebar***** -->
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
<?php  

    function addUsuario(){
        include '/php/conexionBD.php';

        if(strcmp($_POST['pass'],$_POST['pass2'])!=0){
            msgError("Las contraseñas no coinciden.");

        }else{
            $pasEnc=md5($_POST['pass']);
            $imgOK=1;
            $imageType = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
            if($imageType!=""){
                $imgOK=comprobarFoto($_POST['correo']);
                $sql="INSERT INTO usuario (Email, Password, Nombre, Apellidos, Foto) VALUES ('$_POST[correo]', '$pasEnc', '$_POST[nombre]', '$_POST[apelli]', '$imageType')";
            }else{
                $sql="INSERT INTO usuario (Email, Password, Nombre, Apellidos, Foto) VALUES ('$_POST[correo]', '$pasEnc', '$_POST[nombre]', '$_POST[apelli]', NULL)";
            }

            if($imgOK==1){
                if(mysqli_query($conn,$sql)){
                    if(isset($_POST['admin'])){
                        $sql2="INSERT INTO administrador (Email) VALUES ('$_POST[correo]')";
                        mysqli_query($conn,$sql2);

                        $mensaje = "Felicidades! \n Eres unos de los afortunados en ser administrador en 'Compila!' . ";
                        $mensaje = wordwrap($mensaje,70);

                        //$headers = "From: urui.valentin@gmail.com" . "\r\n" . "CC: ".$_POST['correo'];
                        //enviar el email
                        mail($_POST['correo'],"Confirmación de cuenta",$mensaje);
                        echo $_POST['correo'];

                    }
                    msgExito();
                }else{
                    if(mysqli_errno($conn) == 1062){
                        msgErrorCorreo($_POST['correo']);
                    }
                }
            }

            
        }
        
    }

   function comprobarFoto($correo){
        $target_dir = "../imagenes/usuarios/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image

        $nombreFoto=$target_dir.$correo.".".$imageFileType;


        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if($check == false) {
            msgError("El archivo seleccionado no es una imágen.");
            $uploadOk = 0;

            return $uploadOk;
        }

        // Check if file already exists
        if (file_exists($target_file)){
            msgErrorCorreo($correo);
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["imagen"]["size"] > 2097152) {
            msgError("La imágen seleccionada pesa más de 2Mb.");
            $uploadOk = 0;

            return $uploadOk;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            msgError("La imágen seleccionada tiene que están en formato JPG, PNG, JPEG o GIF.");
            $uploadOk = 0;

            return $uploadOk;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return $uploadOk;
        } else {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreFoto);
            return $uploadOk;
        }
    }


?>


</body>
</html>

