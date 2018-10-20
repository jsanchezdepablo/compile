<!doctype html>
<?php include '/php/comprobarUsu.php'; ?>
<html lang="es"><head>
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
        activado(5);
    ?>

    <div class="content">
        <!--CABECERA-->
        <div class="header">
            <h1 class="page-title">Editar Usuario</h1>
            <ul class="breadcrumb">
                <li><a href="usuarios.html">Usuarios</a> </li>
                <li class="active">Editar Usuario</li>
            </ul>
        </div>

        <div class="main-content">
        <?php

            if(isset($_POST['submit']) & isset($_GET['usu'])){
                editarUsuario($_GET['usu']);
            }
        
            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Datos del usuario actualizados.';
                $mensaje.='</div>';
                echo $mensaje;
            }
            function msgErrorCorreo($email){
                $mensaje='<div class="alert alert-danger">';
                $mensaje.='<strong>Error!</strong> Ya existe un usuario con el email <em>'.$email.' </em> en la BD.';
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
        <?php   if(isset($_GET['usu'])){
                    include '/php/conexionBD.php';
                    $usu=$_GET['usu'];
                    
                    $sql="SELECT * FROM usuario WHERE usuario.Email='$usu'";

                    $result = mysqli_query($conn, $sql);

                    $nombre="";
                    $apellidos="";
                    while($row = mysqli_fetch_assoc($result)) {           
                        $nombre=$row['Nombre'];
                        $apellidos=$row['Apellidos'];
                    }
                    
                } 
        ?>

        <div class="row">
            <div class="col-md-4">
                <br>
                <form id="tab" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group" action="" method="POST">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" value="<?php if(isset($usu)) echo $usu; ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="<?php if(isset($usu)) echo $nombre; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apelli" value="<?php if(isset($usu)) echo $apellidos; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Imagen Perfil(2Mb Máx)</label>
                        <input type="file" name="imagen" id="imagen" value="" class="form-control">
                    </div>

                    <hr>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary"value="Actualizar Usuario">
                        <input type="button" class="btn btn-danger" onclick="adios()" value="Descartar Cambios">
                    </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
            function adios(){
                window.location.replace("http://localhost/compila.es/usuarios.php");
            }
            
        </script>


            <footer>
                <hr>
                <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                <p class="pull-right"></p>
                <p>© 2017 <a href="http://www.compila.es" target="_blank">Compila!</a></p>
            </footer>
        </div>
    </div>

    <!-- *****Función que me hace el animado del sidebar***** -->
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  
</body></html>

<?php 
    function editarUsuario($email){
        //*******CONEXION A LA BD
        include '/php/conexionBD.php';

        $nombre=$_POST['nombre'];
        $apellidos=$_POST['apelli'];
        $imgOK=1;
        $imageType = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);

        //*********EN FUNCION DE SI HAY UNA IMAGEN EN EL FORMULARIO CREO LA SQL CON LA EXTENSION DE LA FOTO O NO
        if(filesize($_FILES['imagen']["tmp_name"])!=0 & filesize($_FILES['imagen']["tmp_name"])!=""){
            $imgOK=comprobarFoto($email);
            $sql="UPDATE usuario SET Nombre = '$nombre', Apellidos = '$apellidos', Foto = '$imageType' WHERE usuario.Email = '$email'";
        }else{
            $sql="UPDATE usuario SET Nombre = '$nombre', Apellidos = '$apellidos' WHERE usuario.Email = '$email'";
        }

        //*******************SI HUBO ALGUN PROBLEMA CON LA FOTO NO ACTUALIZO EL USUARIO*****************
        if($imgOK==1){
            if(mysqli_query($conn,$sql)){
                msgExito();
            }else{
                if(mysqli_errno($conn) == 1062){//ERROR QUE ME DA EN CASO DE QUE HAYA UN DUPLICADO EN LA ID
                    msgErrorCorreo($_POST['correo']);
                }
            }
        }

        mysqli_close($conn);
    }

    function comprobarFoto($correo){
        $target_dir = "images/usuarios/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        //*********PREPARO LA URL PARA SUBIR LA FOTO
        $nombreFoto=$target_dir.$correo.".".$imageFileType;

        //***********COMPRUEBO SI ES UNA IMAGEN O NO
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imagen"]["tmp_name"]);
            if($check == false) {
                msgError("El archivo seleccionado no es una imágen.");
                $uploadOk = 0;

                return $uploadOk;
            }
        }

        //*********RUTA ANTIGUA****************
        //Lo que hago aqui es buscar a ver si hay ya una imagen subida de ese usuario y borrarla para introducir la nueva imagen
        include '/php/conexionBD.php';

        $sql="SELECT * FROM usuario WHERE usuario.Email='$correo'";
        $result = mysqli_query($conn, $sql);
        $ext="";
        while($row = mysqli_fetch_assoc($result)){
            $ext=$row['Foto'];
            break;
        }
        mysqli_close($conn);
        echo $ext;
        if($ext!=NULL){
            $antes="images/usuarios/".$correo.'.'.$ext;
        // en caso de que exista el archivo lo borro
            if (file_exists($antes)) {
                unlink($antes);
            }
        }
        //*********FINAL RUTA ANTIGUA FINAL****************
        
        //************COMPRUEBO QUE EL TAMANO DE LA IMAGEN SEA MENOR QUE 2Mb
        if ($_FILES["imagen"]["size"] > 2097152) {
            msgError("La imágen seleccionada pesa más de 2Mb.");
            $uploadOk = 0;

            return $uploadOk;
        }
        //********************SOLO SE PERMITEN CIERTOS FORMATOS PARA LA FOTO
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            msgError("La imágen seleccionada tiene que están en formato JPG, PNG, JPEG o GIF.");
            $uploadOk = 0;

            return $uploadOk;
        }
        //************ Si ha ocurido algun error no subo la foto
        if ($uploadOk == 0) {
            return $uploadOk;
        }else{
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreFoto);
            return $uploadOk;
        }
    }

 ?>