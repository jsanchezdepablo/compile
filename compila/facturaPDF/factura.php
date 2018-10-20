<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "elrinco7_compila";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //echo "Connected successfully";
    $email=$_SESSION['email'];
    //$sql = "SELECT nombre FROM usuarios where curso = 'HTML5'";
    $sql = "SELECT * FROM usuario u WHERE u.Email = '$email'";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_assoc($result)){
      $usuario = $row["Nombre"];
      $apellidos = $row["Apellidos"];
      $email = $row["Email"];
    }
      //echo "<script> console.log(".mysqli_num_rows($result).") </script>";
    ?>
    <?php
    include('phpinvoice.php');
    $invoice = new phpinvoice();
    /* Header Settings */
    $invoice->setLogo("images/logo.png");
    $invoice->setColor("#5cb85c");
    $invoice->setType("Factura");
      //$invoice->setReference("12345");
    

      //Vendedor
    $invoice->setFrom(array("Compila SA","Dirección: C/ La Huerta Nº 1, San Vicente - Alicante","CP: 03006","Tel.: 965 34 53 32 / 625 32 93 98"));


      //Cliente
    $invoice->setTo(array($usuario." ".$apellidos, $email,"",""));
      //$invoice->hide_tofrom();
    /* Adding Items in table */

    $subtotal=0;
    //1...OBTENGO EL ULTIMO ID DE FACTURA CREADO
    $sql="SELECT MAX(Id) AS 'maxId' FROM factura";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $idFactura = $row['maxId'];
    }

    //1.1.....RECOJO LA FECHA DE LA FACTURA
    $sql="SELECT * FROM factura where Id='$idFactura'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $invoice->setDate($row['Fecha_Creacion']);
    }

    //2...OBTENGO TODOS LOS ID's DE LOS PRODUCTOS DE LA FACTURA
    $sql="SELECT Id_Curso FROM linea_factura WHERE Id_Factura='$idFactura'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $idCurso=$row['Id_Curso'];
        //3...SELECCIONO TODA LA INFORMACION DE CADA UNO DE LOS CURSOS
        $sql2="SELECT * FROM curso WHERE Id='$idCurso'";
        $result2 = mysqli_query($conn, $sql2);
        while($row2 = mysqli_fetch_assoc($result2)){
            $tot=$row2['Precio']*((100-$row2['Descuento'])/100);
            $subtotal+=$tot;
            $invoice->addItem($row2['Titulo'],$row2['Descripcion'],$row2['Descuento'],false,$row2['Precio'],false,$tot);
        }
    }
    

    $IVA=round($subtotal*0.21,2);
    $total=$subtotal+$IVA;

   /* $invoice->addItem("AMD Athlon X2DC-7450","2.4GHz/1GB/160GB/SMP-DVD/VB",6,false,580,false,3480);
    $invoice->addItem("PDC-E5300","2.6GHz/1GB/320GB/SMP-DVD/FDD/VB",4,false,645,false,2580);
    $invoice->addItem('LG 18.5" WLCD',"",10,false,230,false,2300);
    $invoice->addItem("HP LaserJet 5200","",1,false,1100,false,1100);*/
    /* Add totals */
    $invoice->addTotal("Subtotal",$subtotal);
    $invoice->addTotal("IVA",$IVA);
    $invoice->addTotal("Total",$total,true);

    $invoice->setFooternote("Compila! Con Pila - 2017");
      //echo "id: " . $row["id"]. "<br>";
    /* Render */
    $invoice->render('factura.pdf','I'); /* I => Display on browser, D => Force Download, F => local path save, S => return document path */
?>
<!DOCTYPE html>
<html>
<head>
	<title>PDF</title>
</head>
<body>

</body>
</html>