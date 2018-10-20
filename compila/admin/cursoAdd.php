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
        activado(7);
    ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">Añadir Curso</h1>
            <ul class="breadcrumb">
                <li><a href="cursos.php">Cursos</a> </li>
                <li class="active">Añadir Curso</li>
            </ul>
        </div>

        <div class="main-content">
        
            <?php
            if(isset($_POST['submit'])){
                addCurso();
            }
            ?>
            <?php  

            function msgExito(){
                $mensaje='<div class="alert alert-success">';
                $mensaje.='<strong>Éxito!</strong> Se ha introducido un nuevo curso a la Base de Datos.';
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
                            <input type="text" name="titulo" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                             <textarea form="tab" name="descr" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nivel</label>
                            <select name="nivel" class="form-control">
                                <option value="1">Básico</option>
                                <option value="2">Intermedio</option>
                                <option value="3">Avanzado</option>}                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Imagen Curso(2Mb Máx)</label>
                            <input type="file" name="imagen" id="imagen" value="" class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                    <label>Precio</label>
                                    <input type="number" step="0.01" name="precio" class="form-control" value="19.99">
                            </div>
                            <div class="form-group col-md-6">
                                    <label>Descuento</label>
                                    <input type="number" name="descuento" class="form-control" min="0" max="100" step="5" value="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Duracion</label>
                                <input type="number" name="duracion" id="duracion" value="4" step="1" min="1" max="20" class="form-control">
                            </div>
                        </div>

                        <div class="form-group checkbox">
                            <label style="font-size: 1.3em">Publicado
                                <input type="checkbox" value="1" name="publicado" class="form-control">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                        
                        <!--<a href="#" class="btn btn-info" id="add" name="caca"><span class="fa fa-plus"></span> Añadir Lección</a>--
                        <input type="button" class="btn btn-info" name="aloha" onclick="caca()">
                        <div id="concat">
                            
                        </div>-->
                       <hr>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary"value="Añadir Curso">
                            <input type="button" class="btn btn-danger" onclick="limpiarForm()" value="Limpiar Formulario">
                        </div>
                    </form>
                </div>
            </div>
            <?php 
                function caca(){
                    echo '<script>console.log("mamasita")</script>';
                }

             ?>
            <script>
                $("#add").click(function(){

                var detailContent = '<h2>JOB EXPERIENCE 1</h2> <div class="job-content"> <input type="text" value="Company" name="company" /> <input type="text" value="Course" name="course" /> <input type="date" value="Date" name="date" /> </div>';    

                $('#concat').append(detailContent); 

                    });
            </script>

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
    
  
</body></html>


<?php  

    function addCurso(){
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
        $fecha = getdate();
        $formato = $fecha['year']."-".$fecha['mon']."-".$fecha['mday']." ".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds'];
        if($imageType!=""){
                $imgOK=comprobarFoto($_POST['titulo']);
                $sql="INSERT INTO curso (Id, Titulo, Descripcion, Nivel, Tema, Foto, Precio, Descuento, Visible, Adm_Email, Duracion, F_creacion, Lecciones) VALUES (NULL, '$_POST[titulo]', '$_POST[descr]', '$_POST[nivel]', '', '$imageType', '$_POST[precio]', '$_POST[descuento]', '$publ', '$_SESSION[email]','$_POST[duracion]','$formato', 8)";
        }else{
                $sql="INSERT INTO curso (Id, Titulo, Descripcion, Nivel, Tema, Foto, Precio, Descuento, Visible, Adm_Email, Duracion, F_creacion, Lecciones) VALUES (NULL, '$_POST[titulo]', '$_POST[descr]', '$_POST[nivel]', '', NULL, '$_POST[precio]', '$_POST[descuento]', '$publ', '$_SESSION[email]','$_POST[duracion]','$formato', 8 )";
        }

        if($imgOK==1){
            if(mysqli_query($conn,$sql)){
                addNoticia();
                msgExito();
            }else{
                $msg="Algo ha ido mal: ".mysqli_error($conn);
                msgError($msg);
            }            
        }
    }

   function comprobarFoto($titulo){
        $target_dir = "../imagenes/cursos/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image

        $nombreFoto=$target_dir.$titulo.".".$imageFileType;


        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if($check == false) {
            msgError("El archivo seleccionado no es una imagen.");
            $uploadOk = 0;

            return $uploadOk;
        }

        // Check if file already exists
        if (file_exists($target_file)){
            msgErrorCorreo($titulo);
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

    function addNoticia(){
        include '/php/conexionBD.php';

        $sql="SELECT max(Id) FROM curso";
        $result = mysqli_query($conn, $sql);

        $id=-1;

        while($row = mysqli_fetch_assoc($result)) {
            // var_dump($row);
            $id=$row['max(Id)'];
        }



        // echo $id;

        $sql2 = "SELECT * FROM curso WHERE Id = $id";
        $result2 = mysqli_query($conn, $sql2);

        while($row2 = mysqli_fetch_assoc($result2)) {
            
            $asunto='¡Nuevo Curso! - '.$row2["Titulo"].' ';
            $mensaje = 'Aquí podrás ver la descripción del nuevo curso <a href="curso.php?id='.$id.'"> '.$row2["Titulo"].'. </a> ';
            
            $sql3="INSERT INTO Noticia VALUES(NULL,'$asunto','$mensaje','$_SESSION[email]')";
            mysqli_query($conn,$sql3);
        }  


        //2.. OBTENER EL MAYOR ID
        $sql="SELECT MAX(Id) AS 'maxId' FROM noticia";
        $result = mysqli_query($conn, $sql);
        $idMAX;
        while($row = mysqli_fetch_assoc($result)) {
            $idMAX=$row['maxId'];
        }

        //3.. OBTENGO TODOS LOS USUARIOS
        $sql = "SELECT Email FROM usuario";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            //4... SE ANYADE EN CADA USUARIO_NOTICIA
            $sql2="INSERT INTO noticia_usuario (Id_Noticia, Id_Usuario,Leido) VALUES ($idMAX, '".$row['Email']."',0)";
            if(mysqli_query($conn,$sql2)){

            }else{
                
            }
        }







    }
// <a href="cursos.php">Cursos</a>

?>