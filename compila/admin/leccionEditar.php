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
        activado(14);
    ?>

    <div class="content"> <!-- INICIO CONTENIDO -->
        <div class="header">
            <h1 class="page-title">Editar Lección</h1>
            <ul class="breadcrumb">
                <li><a href="lecciones.php">Lecciones</a> </li>
                <li class="active">Editar Lección</li>
            </ul>
        </div>
        <div class="main-content"> <!--CONTENIDO PRINCIAL -->
        <?php

            if(isset($_POST['submit']) & isset($_GET['leccion'])){
                editarLeccion($_GET['leccion']);
            }
        
            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Datos de la lección actualizados.';
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
        <?php   if(isset($_GET['leccion'])){
                    include '/php/conexionBD.php';
                    $lecc=$_GET['leccion'];
                    
                    $sql="SELECT * FROM leccion WHERE leccion.Id='$lecc'";

                    $result = mysqli_query($conn, $sql);

                    $titulo="";
                    $contenido="";
                    $ejercicios = "";
                    $solucion_usuario = "";
                    $solucion="";
                    $curso="";
                    while($row = mysqli_fetch_assoc($result)) {           
                        $titulo=$row['Titulo'];
                        $contenido=$row['Contenido'];
                        $ejercicios = $row['Ejercicios'];
                        $solucion_usuario = $row['Solucion_Usuario'];
                        $solucion=$row['Solucion'];
                        $curso=$row['Id_Curso'];
                        $orden_int=$row['Orden_Int'];
                    } 
                }
        ?>

        <div class="row">
            <div class="col-md-6">
                <br>
                <form id="tab" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group" action="" method="POST">
                        <label>Título</label>
                        <input type="text" name="titulo" value="<?php if(isset($lecc)) echo $titulo; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea form="tab" id="w" name="contenido" required><?php if(isset($lecc)) echo $contenido; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Solución</label>
                        <textarea form="tab" name="solucion" class="form-control" rows="6" required><?php if(isset($lecc)) echo $solucion; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ejercicios</label>
                        <textarea form="tab" name="ejercicios" id="w" required><?php if(isset($lecc)) echo $ejercicios; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Soluciones Usuario</label>
                        <textarea form="tab" name="solucion_usuario" id="w" required><?php if(isset($lecc)) echo $solucion_usuario; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Curso Asignado</label>
                            <select name="curso" class="form-control">
                                <?php cursos(); ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Orden Interno</label>
                        <input type="number" name="orden_int" id="" value="<?php echo $orden_int; ?>" step="1" min="1" max="8" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary"value="Actualizar Leccion">
                        <input type="button" class="btn btn-danger" onclick="adios()" value="Descartar Cambios">
                    </div>
                </form>
            </div>
        </div>
        
        <script type="text/javascript">
            function adios(){
                window.location.replace("http://localhost/compila.es/lecciones.php");
            }   
        </script>

            <footer>
                <hr>
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
    function editarLeccion($id_lecc){
        include '/php/conexionBD.php';

        $titulo=$_POST['titulo'];
        $contenido=$_POST['contenido'];
        $ejercicios = $_POST['ejercicios'];
        $solucion_usuario=$_POST['solucion_usuario'];
        $solucion=$_POST['solucion'];
        $orden_int=$_POST['orden_int'];
        $curso=$_POST['curso'];

        $sql="UPDATE leccion SET Titulo = '$titulo', Contenido = '$contenido', Ejercicios = '$ejercicios', Solucion_Usuario = '$solucion_usuario', Solucion = '$solucion', Orden_Int = '$orden_int', Id_Curso='$curso' WHERE leccion.Id = '$id_lecc'";

        if(mysqli_query($conn,$sql)){
            msgExito();
        }else{
            $msg="Algo ha ido mal: ".mysqli_error($conn);
            msgError($msg);
        }
    }

    function cursos(){
        include '/php/conexionBD.php';

        $sql="SELECT * FROM curso";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            if($GLOBALS['curso'] == $row['Id']){
                echo"<option value='".$row['Id']."' selected>".$row['Titulo']."</option>";
            }else{
                echo"<option value='".$row['Id']."'>".$row['Titulo']."</option>";
            }
            
        }

        mysqli_close($conn);
    }
?>