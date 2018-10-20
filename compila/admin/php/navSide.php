<?php 

    function activado($n){
        $dentro="in";

?>

<div class="sidebar-nav">
        <ul>
            <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-fw fa-home"></i>Escritorio<i class="fa fa-collapse"></i></a></li>
            <li>

                <?php if($n==1 || $n==2) 
                        echo "<ul class='dashboard-menu nav nav-list collapse $dentro'>"; 
                      else
                        echo '<ul class="dashboard-menu nav nav-list collapse">';
                ?>
                    <li <?php if($n==1) echo 'class="active"' ?> ><a href="index.php"><span class="fa fa-caret-right"></span> Página Principal</a></li>
                    <li <?php if($n==2) echo 'class="active"' ?> ><a href="media.php"><span class="fa fa-caret-right"></span> Media </a></li>
                </ul>
            </li>

            <li data-popover="true" data-content="" rel="popover" data-placement="right"><a href="#" data-target=".principal-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-users"></i> Usuarios<i class="fa fa-collapse"></i></a></li>
            <li>
                <?php if($n==3 || $n==4 || $n==5) 
                        echo "<ul class='principal-menu nav nav-list collapse $dentro'>"; 
                      else
                        echo '<ul class="principal-menu nav nav-list collapse">';
                ?>
                    <li <?php if($n==3) echo 'class="active"' ?> ><a href="usuarios.php"><span class="fa fa-caret-right"></span> Todos los usuarios</a></li>
                    <li <?php if($n==4) echo 'class="active"' ?> ><a href="usuarioAdd.php"><span class="fa fa-caret-right"></span>Añadir Usuario</a></li>
                    <li <?php if($n==5) echo 'class="active"' ?> ><a href=""><span class="fa fa-caret-right"></span>Editar Usuario</a></li>
                </ul>
            </li>



            <li><a href="#" data-target=".cursos-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-book"></i>Cursos<i class="fa fa-collapse"></i></a></li>
            <li>
                <?php if($n==6 || $n==7 || $n==8) 
                        echo "<ul class='cursos-menu nav nav-list collapse $dentro'>"; 
                      else
                        echo '<ul class="cursos-menu nav nav-list collapse">';
                ?>
                    <li <?php if($n==6) echo 'class="active"' ?> ><a href="cursos.php"><span class="fa fa-caret-right"></span> Todos </a></li>
                    <li <?php if($n==7) echo 'class="active"' ?> ><a href="cursoAdd.php"><span class="fa fa-caret-right"></span> Añadir Curso </a></li>
                    <li <?php if($n==8) echo 'class="active"' ?> ><a href="#"><span class="fa fa-caret-right"></span>Editar Curso</a></li>
                </ul>
            </li>


            <li><a href="#" data-target=".leccion-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-file-code-o"></i>Lecciones<i class="fa fa-collapse"></i></a></li>
            <li>
                <?php if($n==12 || $n==13 || $n==14) 
                        echo "<ul class='leccion-menu nav nav-list collapse $dentro'>"; 
                      else
                        echo '<ul class="leccion-menu nav nav-list collapse">';
                ?>
                    <li <?php if($n==12) echo 'class="active"' ?> ><a href="lecciones.php"><span class="fa fa-caret-right"></span> Todas</a></li>
                    <li <?php if($n==13) echo 'class="active"' ?> ><a href="leccionAdd.php"><span class="fa fa-caret-right"></span> Añadir Leccion </a></li>
                    <li <?php if($n==14) echo 'class="active"' ?> ><a href="#"><span class="fa fa-caret-right"></span>Editar Leccion</a></li>
                </ul>
            </li>


            <li><a href="#" data-target=".noticias-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-globe"></i>Noticias<i class="fa fa-collapse"></i></a></li>
            <li>
                <?php if($n==9 || $n==10 || $n==11) 
                        echo "<ul class='noticias-menu nav nav-list collapse $dentro'>"; 
                      else
                        echo '<ul class="noticias-menu nav nav-list collapse">';
                ?>
                    <li <?php if($n==9) echo 'class="active"' ?> ><a href="noticias.php"><span class="fa fa-caret-right"></span> Todas</a></li>
                    <li <?php if($n==10) echo 'class="active"' ?> ><a href="noticiaAdd.php"><span class="fa fa-caret-right"></span> Añadir Noticia </a></li>
                    <li <?php if($n==11) echo 'class="active"' ?> ><a href="#"><span class="fa fa-caret-right"></span>Editar Noticia</a></li>
                </ul>
            </li>
        
        </ul>
    </div>

<?php } ?>