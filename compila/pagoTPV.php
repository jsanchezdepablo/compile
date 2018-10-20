<?php 
    require_once 'funcionesPhp.php';

    if(isset($_POST['transitarPago'])){
        tramitarPago();
    }
    if(isset($_COOKIE['cantidad_carrito'])){
        $pprint=mostrarPedidoTPV();
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="description">
  <title>Empezar curso</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/javascript.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="javascript/miJava.js"></script>
  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css/estilos.css" rel="stylesheet" type="text/css">

</head>
<body>

  <div id="contenido">
  <header>
      <?php   
        comprobarSesion(23);
        if (isset($_GET['salir']))
            eliminarSesion();
      ?> 
  </header>




<div class="container">
    <br><br><br>
    <!-- <h3 class="encabezadocurso text-center">TPV</h3><hr class="borrar_linea"> -->

<!-- Vendor libraries -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

        <!-- If you're using Stripe for payments -->
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

        <div class="container align-center">
            <div class="row align-center">
                <!-- You can make it whatever width you want. I'm making it full width
                     on <= small devices and 4/12 page width on >= medium devices -->
                      <div class="col-xs-12 col-md-2"></div>
                     <div class="col-xs-12 col-md-4">

                    
                    <!--REVIEW ORDER-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Datos de la compra <div class="pull-right"><small><a class="afix-1" href="carrito.php">Editar Carrito</a></small></div>
                        </div>
                        <div class="panel-body">
                        <?php 
                            /*if(isset($_COOKIE['cantidad_carrito'])){
                                mostrarPedidoTPV();
                            }*/
                            echo $pprint;
                        ?>
                        </div>
                    <!--REVIEW ORDER END-->
                </div>
                    </div>
                <div class="col-xs-12 col-md-4">
                
                
                    <!-- CREDIT CARD FORM STARTS HERE -->
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" >
                            <div class="row display-tr" >
                                <h3 class="panel-title display-td" >Pago con tarjeta</h3>
                                <div class="display-td" >                            
                                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                </div>
                            </div>                    
                        </div>
                        <div class="panel-body">
                            <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="cardNumber">Número de tarjeta</label>
                                            <div class="input-group">
                                                <input 
                                                    type="tel"
                                                    class="form-control"
                                                    name="cardNumber"
                                                    placeholder="Número de Tarjeta Válido"
                                                    autocomplete="cc-number"
                                                    required autofocus 
                                                />
                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="cardExpiry">Fecha de<span class="hidden-xs">vencimiento</span><span class="visible-xs-inline">venc.</span></label>
                                            <input 
                                                type="tel" 
                                                class="form-control" 
                                                name="cardExpiry"
                                                placeholder="MM / AA"
                                                autocomplete="cc-exp"
                                                required 
                                            />
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cardCVC">Cód. CV</label>
                                            <input 
                                                type="tel" 
                                                class="form-control"
                                                name="cardCVC"
                                                placeholder="CV"
                                                autocomplete="cc-csc"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="couponCode">Titular de la tarjeta</label>
                                            <input type="text" class="form-control" name="couponCode" />
                                        </div>
                                    </div>                        
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-xs-12">
                                        <p class="payment-errors"></p>
                                    </div>
                                </div>
                            </form>
                            <form method="POST">
                                <input type="submit" class="subscribe btn btn-success btn-lg btn-block" value="Finalizar Pago" name="transitarPago">
                            </form>
                        </div>
                    </div>            
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                    
                </div> 
                <div class="col-xs-12 col-md-2"></div>         
            </div>
</div>

</div>
    
</div>
      <footer class="section section-primary ">
        <div class="container ">
          <div class="row ">
            <div class="col-sm-6 ">
              <h1>Grupo Braineering</h1>
              <p>2017 © Programming Cloud
                <br>Todos los derechos reservados.</p>
            </div>
            <div class="col-sm-6 ">
              <p class="text-info text-right ">
                <br>
                <br>
              </p>
              <div class="row ">
                <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left ">
                  <a href="# "><i class="fa fa-3x fa-fw fa-instagram text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-twitter text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-facebook text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-github text-inverse "></i></a>
                </div>
              </div>
              <div class="row ">
                <div class="col-md-12 hidden-xs text-right ">
                  <a href="# "><i class="fa fa-3x fa-fw fa-instagram text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-twitter text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-facebook text-inverse "></i></a>
                  <a href="# "><i class="fa fa-3x fa-fw fa-github text-inverse "></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
  </body>

  <script>
function myFunction(id) {

    var value =getCookie('cantidad_carrito');
    var parts = value.split(",");
    var nuevaCookie="";
    for (var i = 0; i < parts.length-1; i++) {
        if(parts[i]==id){
            
        }else{
            nuevaCookie=nuevaCookie.concat(parts[i]);
            nuevaCookie=nuevaCookie.concat(",");
        }
    }


    
    var d = new Date();
    d.setTime(d.getTime() + (10*24*60*60*1000));
    var expira = d.toUTCString();

    document.cookie = "cantidad_carrito="+nuevaCookie+"; expires="+expira+"; path=/;";

    if(parts.length==2)
        document.cookie = "cantidad_carrito=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    window.location.assign("https://localhost/compila/carrito.php");
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
</script>
</html>
