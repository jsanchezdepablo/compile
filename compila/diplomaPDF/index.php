<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elrinco7_compila";
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
//$sql = "SELECT nombre FROM usuarios where curso = 'HTML5'";
$id=$_GET['id'];
$sql = 'SELECT * FROM curso c WHERE Id = '.$id;
//echo $sql;
$result = $conn->query($sql);
while($row = mysqli_fetch_assoc($result)){
  $curso = $row["Titulo"];
}
$usuario = $_SESSION["nombre"];
$apellidos = $_SESSION["apellidos"];

require_once('tcpdf_include.php');
// Remove the default header and footer
class PDF extends TCPDF { 
    public function Header() { 
    // No Header 
    } 
    public function Footer() { 
    // No Footer 
    } 
} 

$pdf = new PDF();
$pdf->setCellPaddings(0,0,0,0);
$html = <<<EOF
<style>
  html {
    border: 5px solid blue;
    color: black;
  }
  h1 {
    color: #5cb85c;
    font-family: times;
    font-size: 30pt;
    text-decoration: none;
    font-family: helvetica;
    text-align:center;
  }
  h2 {
    color: #A4A4A4;
    text-align: right;
  }
  p.aviso{
    color: #A4A4A4;
    font-size: 10pt;
    align: justify;
  }
  p.felicitacion{
    text-align: center;
  }
  i {
    color: black;
  }
</style>
<body>
<h2>Certificado verificado <img src="images/check.png" width="24"><br><br></h2> 
<h1>Para <i>$usuario $apellidos</i>,<br>por completar el curso de <i>$curso</i><br><br><br><br><br><br></h1>
<div class="pie"><p class="felicitacion">Desde <strong>Compila!Con Pila &copy;</strong>, te damos la enhorabuena!</p>
<p class="aviso">* Certificado obtenido al completar uno de los cursos ofrecidos por la plataforma de aprendizaje <strong>Compila! Con Pila &copy;</strong>, por el cual el usuario condecorado puede presentar este documento como prueba de sus habilidades adquiridas durante la realizaci&oacute;n de nuestro curso.</p></div>
</body>
EOF;
$pdf->addPage('L','A4');
$pdf->Image('images/logo.png',10,10,40,40);
$pdf->Image('images/medal.png',137,130,20,20);
$pdf->writeHTML($html, false, false, false, false, 'L');
$pdf->Output('certificado.pdf', 'I');
?>