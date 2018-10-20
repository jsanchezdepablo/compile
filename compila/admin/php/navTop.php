
<div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <a class="" href="index.php"><span class="navbar-brand"><i class="fa fa-fw fa-paper-plane"></i>Compila!</span></a>
        </div>

        <div class="navbar-collapse collapse" style="height: 1px;">
          <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo $_SESSION["nombre"]." ".$_SESSION["apellidos"]; ?>
                    <i class="fa fa-caret-down"></i>
                </a>
              <ul class="dropdown-menu">
                <li><a href="usuarioEditar.php?usu=<?php echo $_SESSION["email"];?>">Perfil</a></li>
                 <li class="divider"></li>
                <li><a tabindex="-1" href="index.php?bye=dew">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
        </div>
</div>

<?php  
    if (isset($_GET['bye'])) {
        byebye();
    }
    function byebye(){
        session_destroy();
        echo '<script> window.location.replace("http://localhost/compila/admin/login.php");</script>';
    }

?>