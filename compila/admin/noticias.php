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
        activado(9);
    ?>

    <div class="content">

        <div class="header">
            <h1 class="page-title">Todas las Noticias</h1>
            <ul class="breadcrumb">
                <li><a href="noticias.html">Noticias</a> </li>
                <li class="active">Todas las Noticias</li>
            </ul>
        </div>

        <div class="main-content">

            <div class="btn-toolbar list-toolbar">
                <a class="btn btn-primary" href="noticiaAdd.php"><i class="fa fa-plus"></i> Añadir Noticia</a>
            </div>
        
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Creador</th>
                        <th style="width: 3.5em;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php  mostrarNoticias();?>
                </tbody>
            </table>

            <?php paginacion(); ?>



            <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Confirmación para Borrar</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="fa fa-warning modal-icon"></i>Estás seguro de querer borrar este usuario?<br>una vez borrado no se podrá volver atrás.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="borrarLeccion();">Borrar</button>
                    </div>
                  </div>
                </div>
            </div> 

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
    function mostrarNoticias(){
        include '/php/conexionBD.php';

        $por_pagina=8;


        if(isset($_GET["pagina"])){
            $pagina=$_GET["pagina"];
        }else{
            $pagina=1;
        }

        $start=($pagina-1) * $por_pagina;



        $sql="SELECT * FROM noticia LIMIT $start,$por_pagina";
        $result = mysqli_query($conn, $sql);

        $fila="";
        $cont = $start+1;
        while($row = mysqli_fetch_assoc($result)) {

            $fila="";

            $fila.='<tr>';
                $fila.='<td>'.$row["Id"].'</td>';
                $fila.='<td>'.$row["Asunto"].'</td>';
                $fila.='<td>'.$row["Mensaje"].'</td>';
                $fila.='<td>'.$row["Email_Admin"].'</td>';
                $fila.='<td>';
                    $fila.='<a href="noticiaEditar.php?noticia='.$row["Id"].'"><i class="fa fa-pencil"></i> </a>';
                    $fila.='<a href="#myModal" id="myLink" role="button" data-toggle="modal"><i class="fa fa-trash-o"></i></a>';
                $fila.='</td>';
            $fila.='</tr>';

            echo $fila;
            $cont++;
        }

        mysqli_close($conn);
    }


    function paginacion(){
        include '/php/conexionBD.php';

        $sql="SELECT * FROM noticia";
        $result = mysqli_query($conn, $sql);
        //num de filas
        $total = mysqli_num_rows($result);
        $total = ceil($total / 8);

        echo '<ul class="pagination">';
        //primera pagina
        echo '<li><a href="noticias.php?pagina=1">&laquo;</a></li>';

        for ($i=1; $i <=$total ; $i++) { 
            echo '<li><a href="noticias.php?pagina='.$i.'">'.$i.'</a></li>';
        }
        //ultima pagina
        echo '<li><a href="noticias.php?pagina='.$total.'">&raquo;</a></li>';
        echo '</ul>';
        
        mysqli_close($conn);
    }

    
?>