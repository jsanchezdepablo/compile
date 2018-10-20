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
        activado(2);
    ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">Media</h1>
                    <ul class="breadcrumb">
            <li><a href="index.html">Escritorio</a></li>
            <li class="active">Media</li>
        </ul>

        </div>
        <div class="main-content">
            <div class="panel panel-default">
                <a href="#widget2container" class="panel-heading" data-toggle="collapse">Fotos Usuarios</a>
                <div id="widget2container" class="panel-body collapse in gallery">
                    <?php mostrarFotos(); ?>
                </div>
            </div>

            <div class="panel panel-default">
                <a href="#widget1container" class="panel-heading" data-toggle="collapse">Fotos Cursos</a>
                <div id="widget1container" class="panel-body collapse in gallery">
                    <?php mostrarFotos2(); ?>
                    <div class="clearfix"></div>
                </div>
            </div>

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

    function mostrarFotos(){

        $handle = opendir("../imagenes/usuarios");
        while($file = readdir($handle)){
            if($file !== '.' && $file !== '..'){
                echo '<img src="../imagenes/usuarios/'.$file.'" border="0" height="140" width="140"/>';
            }
        }
    }

    function mostrarFotos2(){
        $handle = opendir('../imagenes/cursos');
        while($file = readdir($handle)){
            if($file !== '.' && $file !== '..'){
                echo '<img src="../imagenes/cursos/'.$file.'" border="0" height="140" width="140"/>';
            }
        }
    }
 ?>
