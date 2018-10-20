<!doctype html>

<html lang="en"><head>
    <meta charset="utf-8">
    <title>Bootstrap Admin</title>
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
        #line-chart{
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
            color: #fff;
        }
    </style>

    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <span class="navbar-brand"><span class="fa fa-paper-plane"></span> Compila!</span>
        </div>  
    </div>
    
    <div class="dialog"><!--INICIO LOGIN ENTERO-->
        <div class="panel panel-default"><!--INICIO LOGIN FORMULARIO-->
    
        <p class="panel-heading no-collapse">Inicio Sesión</p>
            <div class="panel-body">
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="text" name="correo" class="form-control span12" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="pass" class="form-controlspan12 form-control">
                    </div>
                    <!--<a href="index.html" class="btn btn-primary pull-right">Entrar</a>-->
                    <input type="submit" name="submit" class="btn btn-primary pull-right"value="Entrar">
                    <label class="remember-me"><input type="checkbox" name="recuerda"> Recuerdame</label>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div><!--END LOGIN FORMULARIO-->
        <p><a href="recuperaContrasena.php">¿Has olvidado la contraseña?</a></p>
            <?php 
            
                if(isset($_COOKIE['error_sesion'])){
                    echo ' <div class="alert alert-danger">';
                        echo '<strong>Error! </strong>'.$_COOKIE['error_sesion'];
                        setcookie("error_sesion", "", time()-3600);
                    echo '</div>';
                }
            ?>
        
    </div><!--END LOGIN ENTERO-->



    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  
</body></html>
