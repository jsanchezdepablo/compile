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
        activado(8);
    ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">Editar Curso</h1>
            <ul class="breadcrumb">
                <li><a href="cursos.html">Cursos</a> </li>
                <li class="active">Editar Curso</li>
            </ul>
        </div>

        <?php 
            if(isset($_POST['submit']) & isset($_GET['curso'])){
                editarCurso($_GET['curso']);
            }
         ?>

        <?php   if(isset($_GET['curso'])){
                    include '/php/conexionBD.php';
                    $curs=$_GET['curso'];
                    
                    $sql="SELECT * FROM curso WHERE curso.Id='$curs'";

                    $result = mysqli_query($conn, $sql);

                    $titulo="";
                    $descripcion="";
                    $nivel="";
                    $precio="";
                    $descuento="";
                    $publicado="";
                    $duracion="";
                    while($row = mysqli_fetch_assoc($result)) {           
                        $titulo=$row['Titulo'];
                        $descripcion=$row['Descripcion'];
                        $nivel=$row['Nivel'];
                        $precio=$row['Precio'];
                        $descuento=$row['Descuento'];
                        $publicado=$row['Visible'];
                        $duracion=$row['Duracion'];
                    } 
                }
        ?>
        <div class="main-content">
        <?php  
            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Datos del curso actualizados.';
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
                <div class="col-md-6">
                <br>
                    <form id="tab" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group" action="" method="POST">
                            <label>Título</label>
                            <input type="text" name="titulo" value="<?php if(isset($curs)) echo $titulo; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                             <textarea form="tab" name="descr" value="" class="form-control" rows="6" required><?php if(isset($curs)) echo $descripcion; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nivel</label>
                            <select name="nivel" class="form-control">
                                <option value="1" <?php if($nivel==1) echo "selected" ?> >Básico</option>
                                <option value="2" <?php if($nivel==2) echo "selected" ?> >Intermedio</option>
                                <option value="3" <?php if($nivel==3) echo "selected" ?> >Avanzado</option>}                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Imagen Curso(2Mb Máx)</label>
                            <input type="file" name="imagen" id="imagen" value="" class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                    <label>Precio</label>
                                    <input type="number" step="0.01" name="precio" class="form-control" value="<?php if(isset($curs)) echo $precio; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                    <label>Descuento</label>
                                    <input type="number" name="descuento" class="form-control" min="0" max="100" step="5" value="<?php if(isset($curs)) echo $descuento; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Duracion</label>
                                <input type="number" name="duracion" id="duracion" step="1" min="1" max="20" class="form-control" value="<?php if(isset($curs)) echo $duracion; ?>">
                            </div>
                        </div>

                        <div class="form-group checkbox">
                            <label style="font-size: 1.3em">Publicado
                                <input type="checkbox" value="1" name="publicado" class="form-control" <?php if($publicado==1) echo "checked" ?>>
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                        

                       <hr>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary"value="Actualizar Curso">
                            <input type="button" class="btn btn-danger" onclick="adios()" value="Descartar Cambios">
                        </div>
                    </form>
                </div>
            </div>

            <script type="text/javascript">
                function adios(){
                    window.location.replace("http://localhost/compila.es/cursos.php");
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

    function editarCurso($curso){
        include '/php/conexionBD.php';
        //****COMPRUEBO LA EXTENSION DE LA FOTO
        $imageType = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
        //****COMPRUEBO SI ES VISIBLE O NO
        if(isset($_POST['publicado'])){
            $publ=1;
        }else{
            $publ=0;
        }
        $imgOK=1;
        if($imageType!=""){
            $imgOK=comprobarFoto($_POST['titulo']);             
            $sql="UPDATE curso SET Titulo='$_POST[titulo]', Descripcion = '$_POST[descr]', Nivel = '$_POST[nivel]', Foto = '$imageType', Precio = '$_POST[precio]', Descuento = '$_POST[descuento]', Visible = '$publ', Adm_Email='$_SESSION[email]', Duracion = '$_POST[duracion]' WHERE curso.Id = '$curso'";
        }else{
            $sql="UPDATE curso SET Titulo='$_POST[titulo]', Descripcion = '$_POST[descr]', Nivel = '$_POST[nivel]', Precio = '$_POST[precio]', Descuento = '$_POST[descuento]', Visible = '$publ', Adm_Email='$_SESSION[email]', Duracion = '$_POST[duracion]' WHERE curso.Id = '$curso'";
        }

        if($imgOK==1){
            if(mysqli_query($conn,$sql)){
                msgExito();
            }else{
                $msg="Algo ha ido mal: ".mysqli_error($conn);
                msgError($msg);
            }            
        }
    }

   function comprobarFoto($correo){
        $target_dir = "../imagenes/cursos/";
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
            msgError("Hay un problema con el nombre de la foto. Es posible que lo tengas que cambiar.");
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