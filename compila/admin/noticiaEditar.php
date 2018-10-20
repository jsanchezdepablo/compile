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
        activado(11);
    ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">Editar Noticia</h1>
            <ul class="breadcrumb">
                <li><a href="noticias.html">Noticias</a> </li>
                <li class="active">Editar Noticia</li>
            </ul>
        </div>

        <div class="main-content">

        <?php

            if(isset($_POST['submit']) & isset($_GET['noticia'])){
                editarNoticia($_GET['noticia']);
            }
        
            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Datos de la noticia actualizados.';
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
        <?php   if(isset($_GET['noticia'])){
                    include '/php/conexionBD.php';
                    $not=$_GET['noticia'];
                    
                    $sql="SELECT * FROM noticia WHERE noticia.Id='$not'";

                    $result = mysqli_query($conn, $sql);

                    $asunto="";
                    $mensaje="";
                    while($row = mysqli_fetch_assoc($result)) {           
                        $asunto=$row['Asunto'];
                        $mensaje=$row['Mensaje'];
                    } 
                }
        ?>

        <div class="row">
            <div class="col-md-6">
                <br>
                <form id="tab" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group" action="" method="POST">
                        <label>Asunto</label>
                        <input type="text" name="asunto" value="<?php if(isset($not)) echo $asunto; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Mensaje</label>
                        <textarea form="tab" name="mensaje" class="form-control" rows="6" required><?php if(isset($not)) echo $mensaje; ?></textarea>
                    </div>

                    <hr>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary"value="Actualizar Noticia">
                        <input type="button" class="btn btn-danger" onclick="adios()" value="Descartar Cambios">
                    </div>
                </form>
            </div>
        </div>
        
        <script type="text/javascript">
            function adios(){
                window.location.replace("http://localhost/compila.es/noticias.php");
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
    
  
</body></html>


<?php 
    function editarNoticia($id_not){
        include '/php/conexionBD.php';

        $asunto=$_POST['asunto'];
        $mensaje=$_POST['mensaje'];

        $sql="UPDATE noticia SET Asunto = '$asunto', Mensaje = '$mensaje' WHERE noticia.Id = '$id_not'";

        if(mysqli_query($conn,$sql)){
            msgExito();
        }else{
            $msg="Algo ha ido mal: ".mysqli_error($conn);
            msgError($msg);
        }
    }
?>