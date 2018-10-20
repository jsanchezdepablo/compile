<!doctype html>
<?php
session_start();

    if (isset($_POST['submit'])){
        include '/php/conexionBD.php';
        $error="";
        //*SI ALGUNO DE LOS CAMPOS ESTA VACIO -- ERROR
        if (empty($_POST['correo']) || empty($_POST['pass'])) {
            $error = "Tienes que rellenar todos los campos.";
            errorInicio($error);
        }else{
            $sql="SELECT a.Email FROM administrador a WHERE a.Email='".$_POST['correo']."'";
            
            $result = $conn->query($sql);
            //ENCRIPTO LA CONTRASEÑA DEL USUARIO PARA COMPROBARLA CON LA DE LA BD
            $pasEnc=md5($_POST['pass']);

            //*******PRIMERO COMPRUEBO QUE EXISTE EL USUARIO EN LA TABLA 'ADMINISTRADOR'
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    //***2a SELECT PARA COMPROBAR LA CONTRASEÑA DEL USUARIO
                    $sql2="SELECT * FROM usuario u WHERE u.Email='".$_POST['correo']."'";
                    $result2 = mysqli_query($conn, $sql2);
                    
                    while($row2 = mysqli_fetch_assoc($result2)){
                        //****COMPRUEBO QUE LAS CONTRASEÑAS COINCIDEN
                        if(strcmp($pasEnc,$row2['Password'])==0){
                            
                            $_SESSION["email"] = $row2["Email"];
                            $_SESSION["pass"] = $row2["Password"];
                            $_SESSION["nombre"] = $row2["Nombre"];
                            $_SESSION["apellidos"] = $row2["Apellidos"];
                            $_SESSION["foto"] = $row2["Foto"];

                        }else{
                            $error = "El usuario y/o la contraseña con incorrectos.";
                            errorInicio($error);
                        }
                    }
                    
                }
            }else{
                $error = "El usuario y/o la contraseña con incorrectos.";
                errorInicio($error);
            }

        }
       // mysqli_close($conn);
    }else{
        //EN CASO DE QUE LA SESION NO ESTE INICIADA REDIRECCIONO A INDEX
        //if(session_status() == PHP_SESSION_NONE){
        //if(!isset($_SESSION)){
        if(!isset($_SESSION['email'])){
            $error = "Inicia Sesión para poder acceder al panel de administración.";
            errorInicio($error);
        }
    }

    
    function errorInicio($error){
        setcookie("error_sesion",$error,time()+3);
        header("Location: http://localhost/compila/admin/login.php");
    }
?>
<html lang="en">
<head>
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
        activado(1);
    ?>
    
    
    <div class="content">
        <div class="header">
            <h1 class="page-title">Página Principal</h1>
            <ul class="breadcrumb">
                <li><a href="index.html">Escritorio</a> </li>
                <li class="active">Página Principal</li>
            </ul>
        </div>

        <div class="main-content">


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
    
  
</body></html>
