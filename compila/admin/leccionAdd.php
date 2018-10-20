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

    
    <?php include '/php/wysiwyg.php' ?>

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
        activado(13);
    ?>

    <div class="content"> <!-- INICIO CONTENIDO -->
        <div class="header">
            <h1 class="page-title">Añadir Lección</h1>
            <ul class="breadcrumb">
                <li><a href="lecciones.php">Lecciones</a> </li>
                <li class="active">Añadir Lección</li>
            </ul>
        </div>

        <div class="main-content"> <!--CONTENIDO PRINCIAL -->
         <?php
            if(isset($_POST['submit'])){
                addLeccion();
            }

        
            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Se ha introducido una nueva lección a la Base de Datos.';
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
                <div class="col-md-8">
                <br>
                    <form id="tab" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="titulo" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea form="tab" id="w" name="contenido" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Solución</label>
                            <textarea form="tab" name="solucion" id="w" required></textarea>
                        </div>
                         <div class="form-group">
                            <label>Ejercicios</label>
                            <textarea form="tab" name="ejercicios" id="w" required></textarea>
                        </div>
                         <div class="form-group">
                            <label>Soluciones Usuario</label>
                            <textarea form="tab" name="solucion_usuario" id="w" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Asignar Curso</label>
                            <select name="curso" class="form-control">
                                <?php cursos(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                                <label>Orden Interno</label>
                                <input type="number" name="orden_int" id="" value="" step="1" min="1" max="8" class="form-control">
                        </div>

                        <hr/>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary"value="Añadir Lección">
                            <input type="button" class="btn btn-danger" onclick="limpiarForm()" value="Limpiar Formulario">
                        </div>
                       

                    </form>
                </div>
            </div>
    

            <footer>
                <hr>
                <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                <p class="pull-right"></p>
                <p>© 2017 <a href="http://www.compila.es" target="_blank">Compila!</a></p>
            </footer>
        </div> <!--END CONTENIDO PRINCIAL -->
    </div> <!-- END CONTENIDO -->

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

    function addLeccion(){
        include '/php/conexionBD.php';
        $sql="INSERT INTO leccion VALUES (NULL, '$_POST[titulo]', '$_POST[contenido]', '$_POST[ejercicios]', '$_POST[solucion_usuario]', '$_POST[solucion]', '$_POST[orden_int]', '$_POST[curso]')";
        

        if(mysqli_query($conn,$sql)){
            msgExito();
        }else{
            $msg="Algo ha ido mal: ".mysqli_error($conn);
            msgError($msg);

        }
        mysqli_close($conn);
    }

    function cursos(){
        include '/php/conexionBD.php';

        $sql="SELECT * FROM curso";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            echo"<option value='".$row['Id']."'>".$row['Titulo']."</option>";
        }

        mysqli_close($conn);
    }
?>