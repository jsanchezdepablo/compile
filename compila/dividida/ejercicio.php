<!DOCTYPE html>
<html land="es">
<?php   session_start(); 
        $hola="blabla"; 
        $tituloLeccion="noHay";
        include '/php/conexionBD.php';
        //lo hago para redireccionar a la misma pagina con el GET de la leccion puesto
        if(isset($_GET["id"]) && $_SESSION["email"] != NULL){
                    anyadirMisCursos();
        } 
        if(!isset($_GET['leccion']))
            redirigirConLeccion();
        $contenido="";
        $ejercicios="";
        $soluciones="";
        $acabadas=0;
?>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pantalla Dividida</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href='IconFonts/_ICONFONT/styles.css' rel='stylesheet' type='text/css'>
        <link href='IconFonts/foundation-icons/foundation-icons.css' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">       
        
        <script type="text/javascript" src="js/jquery.min.js"></script>
         <script type="text/javascript" src="js/jquery-linedtextarea.js"></script>
        <!-- SCRIPTS PARA WEBGL -->
        <script type="text/javascript" src="pseudo/js/glMatrix-0.9.5.min.js"></script>
        <script type="text/javascript" src="pseudo/js/webgl-utils.js"></script>
        <script type="text/javascript" src="pseudo/js/gestorRecursos.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/tree.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tnodo.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tentidad.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Ttransf.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tluz.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tcamara.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tmalla.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/Tanimacion.js"></script>
        <script type="text/javascript" src="pseudo/js/arbol/interpolacion.js"></script>
        <script type="text/javascript" src="pseudo/js/interfaceMotor.js"></script>
        <script type="text/javascript" src="pseudo/js/inicioWebGL.js"></script>
        <script type="text/javascript" src="pseudo/js/lectura.js"></script>

        <!--<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css"> -->
        <script id="per-fragment-lighting-fs" type="x-shader/x-fragment">
            precision mediump float;

            //LAS VARIABLES VARYING PASAN DATOS DE UN SHADER A OTRO
            varying vec2 vTextureCoord;
            varying vec3 vTransformedNormal;
            varying vec4 vPosition;

            //ESTO SERA PAR EL BRILLO DEL MATERIAL, PERO ANTES QUIERO VER SI ME FUNCIONAN BIEN LAS LUCES
            uniform float uMaterialShininess;
            uniform bool uUseLighting;
            uniform bool uUseTextures;

            //EN ESTA VARIABLE ALMACENAMOS LA INTENSIDAD DE LA LUZ AMBIENTAL
            uniform vec3 uAmbientColor;
            //NUMERO DE LUCES NORMALES
            uniform int uNLights;
            //AQUI ME CREO UN ARRAY DE VECTORES CON LA POSICION DE LAS LUCES
            uniform float uScenePointLights[54];
            
            //NUMERO DE LUCES NORMALES
            uniform int uNDirectionalLights;
            uniform float uSceneDirectionalLights[78];   
            
            //LA VARIABLE SAMPLER SE ENCARGA DE LEER LA TEXTURA
            uniform sampler2D uSampler;

            void main(void) {
                //INICIALIZAMOS LA INTENSIDAD DANDOLE EL VALOR DEL DE LA LUZ AMBIENTAL
                vec3 lightWeighting;
                if (!uUseLighting) {
                    lightWeighting = vec3(1.0, 1.0, 1.0);
                }else{
                    lightWeighting = uAmbientColor;

                    vec3 lDirection;
                    vec3 eyeDirection;
                    vec3 reflectionDirection;
                    vec3 normal = normalize(vTransformedNormal);
                    vec3 auxIntensidad;
                    float specularLightWeighting;
                    float diffuseLightWeighting;
                    
                    bool operar = true;
                    int iterador = 0;

                    vec3 posAux;
                    vec3 difAux;
                    vec3 espAux;
                    vec3 dirAux;
                    float angAux;
                    for(int i=0; i<54; i+=9){
                        if(operar){
                            posAux = vec3(
                                        uScenePointLights[i], 
                                        uScenePointLights[i+1], 
                                        uScenePointLights[i+2]
                                    );

                            difAux = vec3(
                                        uScenePointLights[i+3], 
                                        uScenePointLights[i+4], 
                                        uScenePointLights[i+5]
                                    );

                            espAux = vec3(
                                        uScenePointLights [i+6], 
                                        uScenePointLights [i+7], 
                                        uScenePointLights [i+8]
                                    );

                            lDirection = normalize(posAux - vPosition.xyz);
                            //NORMALIZAR DIRECCION DE LA VISTA
                            eyeDirection = normalize(-vPosition.xyz);
                            //NORMALIZAR VECTOR DIRECCION DE LA LUZ REFLEJADA (CON LA FUNCION DE GLSL REFLECT)
                            reflectionDirection = reflect(-lDirection, normal);

                            //PRODUCTO ESCARLAR DE LA ORIENTACION DEL VERTICE POR LA DIRECCION DE LA LUZ (EN ESTE CASO LA REFLEJADA) PARA ESE VERTICE
                            //DE ESTA FORMA OBTENEMOS EL PESO DE LA LUZ SOBRE ESE PUNTO
                            specularLightWeighting = pow(max(dot(reflectionDirection, eyeDirection), 0.0), uMaterialShininess);
                            //HACEMOS LO PROPIO CON LA LUZ DIFUSA
                            diffuseLightWeighting = max(dot(normal, lDirection), 0.0);

                            auxIntensidad = espAux * specularLightWeighting + difAux * diffuseLightWeighting;

                            lightWeighting = lightWeighting + auxIntensidad;

                            iterador++;
                            if(iterador >= uNLights){
                                operar = false;
                            }
                        }
                    }

                    iterador = 0;
                    operar = true;
                    float angleFocus;

                    for(int i=0; i<78; i +=13){
                        if(operar){
                            posAux = vec3(
                                        uSceneDirectionalLights[i], 
                                        uSceneDirectionalLights[i+1], 
                                        uSceneDirectionalLights[i+2]
                                    );

                            difAux = vec3(
                                        uSceneDirectionalLights[i+3], 
                                        uSceneDirectionalLights[i+4], 
                                        uSceneDirectionalLights[i+5]
                                    );

                            espAux = vec3(
                                        uSceneDirectionalLights[i+6], 
                                        uSceneDirectionalLights[i+7], 
                                        uSceneDirectionalLights[i+8]
                                    );

                            dirAux = vec3(
                                        uSceneDirectionalLights[i+9], 
                                        uSceneDirectionalLights[i+10], 
                                        uSceneDirectionalLights[i+11]
                                    );
                            
                            angAux = uSceneDirectionalLights[i+12];

                            if(angAux >= 0.0 && angAux < 1.0){
                                // CALCULAMOS EL ANGULO ENTRE LA DIRECCION DE LA LUZ Y EL VERTICE ACTUAL
                                angleFocus = max(dot(dirAux, lDirection), 0.0);
                                //SI ESTE ANGULO ES MENOR AL MAXIMO PREESTABLECIDO, OPERAMOS
                                if(angleFocus < angAux){
                                    lDirection = normalize(posAux - vPosition.xyz);
                                    //NORMALIZAR DIRECCION DE LA VISTA
                                    eyeDirection = normalize(-vPosition.xyz);
                                    //NORMALIZAR VECTOR DIRECCION DE LA LUZ REFLEJADA (CON LA FUNCION DE GLSL REFLECT)
                                    reflectionDirection = reflect(-lDirection, normal);

                                    //PRODUCTO ESCARLAR DE LA ORIENTACION DEL VERTICE POR LA DIRECCION DE LA LUZ (EN ESTE CASO LA REFLEJADA) PARA ESE VERTICE
                                    //DE ESTA FORMA OBTENEMOS EL PESO DE LA LUZ SOBRE ESE PUNTO
                                    specularLightWeighting = pow(max(dot(reflectionDirection, eyeDirection), 0.0), uMaterialShininess);
                                    //HACEMOS LO PROPIO CON LA LUZ DIFUSA
                                    diffuseLightWeighting = max(dot(normal, lDirection), 0.0);
                                    //Y SUMAMOS ESTOS VECTORES DE INTENSIDAD A LA INTENSIDAD GENERAL DEL PUNTO QUE QUEREMOS ILUMINAR
                                    auxIntensidad = espAux * specularLightWeighting + difAux * diffuseLightWeighting;
                                }
                            }

                            lightWeighting = lightWeighting + auxIntensidad;

                            iterador++;
                            if(iterador >= uNDirectionalLights){
                                operar = false;
                            }
                        }
                    }
                }

                vec4 fragmentColor;
                if (uUseTextures) {
                    fragmentColor = texture2D(uSampler, vec2(vTextureCoord.s, vTextureCoord.t));
                } else {
                    fragmentColor = vec4(1.0, 1.0, 1.0, 1.0);
                }
                gl_FragColor = vec4(fragmentColor.rgb * lightWeighting, fragmentColor.a);
            }

        </script>

        <script id="per-fragment-lighting-vs" type="x-shader/x-vertex">
            attribute vec3 aVertexPosition;
            attribute vec3 aVertexNormal;
            attribute vec2 aTextureCoord;

            uniform mat4 uMVMatrix;
            uniform mat4 uPMatrix;
            uniform mat3 uNMatrix;

            varying vec2 vTextureCoord;
            varying vec3 vTransformedNormal;
            varying vec4 vPosition;

            void main(void) {
                //EL CALCULO DE GL_POSITION LO HAGO EN DOS PASOS YA QUE VPOSITION TAMBIEN LO UTILIZARE POR SEPARADO MAS ADELANTE
                vPosition = uMVMatrix * vec4(aVertexPosition, 1.0);
                gl_Position = uPMatrix * vPosition;
                
                vTextureCoord = aTextureCoord;
                vTransformedNormal = uNMatrix * aVertexNormal;
            }
        </script>
        
	<style>
        #titLecion {
            white-space: nowrap; 
            width: 9.8em; 
            overflow: hidden;
            text-overflow: ellipsis; 
        }
    </style>
	</head>
	<body onload="iniciarWebGL();">
        <figure>
            <img src="pseudo/img/fondoDividida.png"  height="700" width="1520">
        </figure>
        <header>
            <nav>
                 <a href="../index.php">Compila!</a>
            </nav>
            <span> <?php nombreCurso(); ?> </span>
            
            <nav>
                <input type="checkbox" id="menuNav"/>
                <ul>
                    <li><label for="menuNav"><img src="<?php fotoPerfil(); ?>" class="img-circle" alt="Cinque Terre" width="30" height="30"></label></li>
                    <li class="navList"><a href="../Perfil.php">Perfil</a></li>
                    <li class="navList"><a href="../misCursos.php">Mis Cursos</a></li><hr>
                    <li class="navList"><a href="../index.php?salir=ok">Salir</a></li>
                </ul>
            </nav>
      </header>

	 	<section>
            <article>
                <section class="barraLecciones">
                    <input type="checkbox" id="menu-trigger"/>
                    <ul>
                        <li><label for="menu-trigger"><span>&equiv;</span></label></li>
                       <!-- <li class="listaLeccion">Leccion<span>1</span></li>
                       <li class="listaLeccion"><a href="ejercicio.php?id='.$_GET['id'].'&leccion='.$row['Id'].'" class="acabado"> leccion 1 </a></li>
                       <li class="listaLeccion"><a href="ejercicio.php?id=9&leccion='.$row['Id'].'" class="activo">leccion 2</a></li>
                       <li class="listaLeccion"><a href="ejercicio.php?id=9&leccion='.$row['Id'].'" class="disabled">leccion 3</a></li>-->
                       
                        <?php cargarLecciones(); ?>
                    </ul>
                </section>
                <section>
                    <div>
                        <h3 id="titLecion"><?php echo $tituloLeccion ?> </h3>
                       <div>
                            <?php if($_GET['leccion']>1){ 
                                    $lecc=$_GET['leccion']-1;
                                    $ref='onclick="location.href='."'"."ejercicio.php?id=".$_GET['id']."&leccion=".$lecc."'".'"';
                                    $clase="activo";
                                    $lala="";
                                  }else{
                                    $ref="";
                                    $clase="disabled";
                                    $lala="disabled";
                                  }           
                            ?>
                            <input type="button" class="<?php echo $clase; ?>" value="Anterior" <?php echo $ref ?> <?php echo $lala ?>>
                            
                            <span><?php echo $_GET['leccion'] ?>/8</span>
                             <?php if($_GET['leccion']<8 && $_GET['leccion']<=$acabadas){
                                    $lecc=$_GET['leccion']+1;
                                    $ref='onclick="location.href='."'"."ejercicio.php?id=".$_GET['id']."&leccion=".$lecc."'".'"';
                                    $clase="activo";
                                    $lala="";
                                  }else{
                                    $lecc=$_GET['leccion']+1;
                                    $ref='onclick="location.href='."'"."ejercicio.php?id=".$_GET['id']."&leccion=".$lecc."'".'"';
                                    $clase="disabled";
                                    $lala="disabled";
                                  }
                                  if($_GET['leccion']==8){
                                    $boton="Finalizar";
                                    $ref='onclick="location.href='."'"."../certificado.php?id=".$_GET['id']."&n=".$nombreCurso."'".'"';
                                  }else{
                                    $boton="Siguiente";
                                  }
                            ?>
                            <input type="button" id="alaba" class="<?php echo $clase ?>" value="<?php echo $boton ?>" <?php echo $ref ?> <?php echo $lala ?>>

                        </div>
                    </div>
                    <div>
                        <input type="checkbox" id="checkLeccion">
                        <ul>
                            <li class="encabezado">
                                <label for="checkLeccion">
                                    <span class="fi-book-bookmark"> Apuntes</span>
                                    <span class="fi-arrow-up"></span>
                                </label>
                            </li>
                            <li>
                                <?php 
                                    cargarContenido();
                                    echo $contenido;  
                                ?>
                            </li>
                        </ul>
                        <input type="checkbox" id="checkEjercicio">
                        <ul>
                            <li class="encabezado">
                                <label for="checkEjercicio">
                                    <span class="fi-page-edit"> Ejercicios</span>
                                    <span class="fi-arrow-up"></span>
                                </label>
                            </li>
                            <li>
                                 <?php echo $ejercicios; ?>
                            </li>
                        </ul>
                        <input type="checkbox" id="checkSolucion">
                        <ul>
                            <li class="encabezado">
                                <label for="checkSolucion">
                                    <span class="fi-info"> Soluciones</span>
                                    <span class="fi-arrow-up"></span>
                                </label>
                            </li>
                            <li>
                                <?php echo $soluciones; ?>
                            </li>
                        </ul>
                    </div>
                </section>
			</article>
			
			<article>
				<h3 class="icon-basic-sheet-pen"> Editor de Texto</h3>
				<textarea id="terminal"></textarea>
                <div class="consolaBotones">
                    <input type="button" value="Compila!" onclick="lecturaTextArea('<?php echo $_SESSION['email'] ?>');">
                    <button class="fi-loop" onclick="iniciarWebGL();"></button>
                </div>
                <script>
                    $(function() {
                        $("#terminal").linedtextarea();
                    });
                </script>
                <aside>
                    <input type="checkbox" id="mostrarConsola">
                    <ul id="respuesaAConsola">
                        <li><label for="mostrarConsola"><span class="fi-graph-horizontal"></span></label></li>
                    </ul>
                    <canvas id="consola" width="600" height="350"></canvas>
                </aside>
			</article>
	 	</section>

	</body>
    <script>
        
        function getParameterByName(name){
            url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
</html>
<?php 

function anyadirMisCursos(){
    global $conn;

    $url= $_GET["id"];

    $email = $_SESSION["email"];

    $fecha = getdate();
    $formato = $fecha['year']."-".$fecha['mon']."-".$fecha['mday']." ".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds'];
    $sql = "INSERT INTO curso_usuario VALUES ('$email', Lecc_Completadas, Calificacion_Test, $url, '$formato',0)"; 

    if(mysqli_query($conn,$sql)){
            echo '<script>console.log("HOla...'.mysqli_errno($conn).'")</script>';
    }else{
        $sql = "UPDATE curso_usuario SET F_inicio ='$formato' WHERE Id_Curso = $url AND Email_Usu = '$email' "; 
        mysqli_query($conn,$sql);
    }       
                   
}
function cargarLecciones(){
    global $hola;
    global $nombreCurso;
    global $acabadas;
    global $tituloLeccion;
    $hola="lalalalla";
    global $text;
    global $contenidoLeccion;
    global $conn;
    $id = $_GET['id'];

    $sql="SELECT * FROM curso WHERE Id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $nombreCurso=$row['Titulo'];
        break;
    }



    $usu = $_SESSION['email'];
    // include("/admin/php/conexionBD.php");
    $comp; //numero de lecciones completadas por el usuario
    $numFila=1; //numero de filas
    $sql="SELECT * FROM leccion WHERE Id_Curso = $id";

    //primero obtenemos el numero de lecciones completadas
    $sql2="SELECT Lecc_Completadas FROM curso_usuario WHERE Id_Curso = $id AND Email_Usu = '$usu' ";
    $result2=mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)){
        $comp=$row2["Lecc_Completadas"];
    }
    //me guardo las lecciones acabadas
    $acabadas=$comp;
    $result = mysqli_query($conn, $sql);
    $rowcount=mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){

        if($comp>=0){//lecciones completadas
            //echo $comp;
            if($_GET['leccion']==$row['Orden_Int']){
                $fila='<li class="listaLeccion"><a href="ejercicio.php?id='.$_GET['id'].'&leccion='.$row['Orden_Int'].'" class="activo">'.$numFila.'. '.$row['Titulo'].'</a></li>';
            }else{
                $fila='<li class="listaLeccion"><a href="ejercicio.php?id='.$_GET['id'].'&leccion='.$row['Orden_Int'].'" class="acabado">'.$numFila.'. '.$row['Titulo'].'</a></li>';
            }
        }else{//lecciones no completadas
            $fila='<li class="listaLeccion"><a href="ejercicio.php?id='.$_GET['id'].'&leccion='.$row['Orden_Int'].'" class="disabled"></span>'.$numFila.'. '.$row['Titulo'].'</a></li>';
        }
        $comp--;

        //lo hago para recoger el titulo de la lecccion en la que estoy
        if($row['Orden_Int']==$_GET['leccion']){
            $tituloLeccion=$row['Titulo'];
        }
        
        if($numFila<=$rowcount){
            $numFila++;
        }

        
        echo $fila;
    }
}

function cargarContenido(){
    $id = $_GET['id'];
    $usu = $_SESSION['email'];
    $orden = $_GET['leccion'];
    global $conn;
    global  $contenido;
    global $ejercicios;
    global $soluciones;

    $sql="SELECT * FROM leccion WHERE Id_Curso = $id AND Orden_Int=$orden";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $contenido = $row['Contenido'];
        $ejercicios = $row['Ejercicios'];
        $soluciones = $row['Solucion_Usuario'];
    }
}

function nombreCurso(){
    global $conn;
    $id = $_GET['id'];
    // include("/admin/php/conexionBD.php");
    $sql="SELECT Titulo FROM Curso WHERE Id = $id";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        echo $row["Titulo"];
        break;
    }

    
}

function fotoPerfil(){
    global $conn;//Declaro la var como global para poder acceder a ella dentro de la funcion
       
    $sql = "SELECT * FROM usuario WHERE Email ='". $_SESSION['email']."'";  
    $aux = ".";
    $result = $conn->query($sql);

    if($result->num_rows > 0){ //Hay cursos en la BD

               
        while($row = mysqli_fetch_assoc($result)){
                if($row["Foto"] != NULL)
                    echo '../imagenes/usuarios/'.$row["Email"].$aux.$row["Foto"];
                else
                    echo '../imagenes/usuarios/sinFoto.jpg';
        }
    }
}

function redirigirConLeccion(){
    global $conn;

    $leccionActual;
    $id = $_GET['id'];
    $usu = $_SESSION['email'];
    // include("/admin/php/conexionBD.php");
    $comp; //numero de lecciones completadas por el usuario
    $sql="SELECT * FROM leccion WHERE Id_Curso = $id";

    //primero obtenemos el numero de lecciones completadas
    $sql2="SELECT Lecc_Completadas FROM curso_usuario WHERE Id_Curso = $id AND Email_Usu = '$usu' ";
    $result2=mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)){
        $comp=$row2["Lecc_Completadas"];
    }
    $aux=$comp;
    $result = mysqli_query($conn, $sql);
    $rowcount=mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
        if($comp==0){
            $leccionActual=$row['Orden_Int'];
        }
        //echo '<script>console.log("'.$comp.'")</script>';
        $comp--;
    }
    if($aux>=8){
        $leccionActual=1;
    }

    if(!isset($_GET['leccion']))
        echo '<script>window.location.assign("ejercicio.php?id='.$_GET['id']."&leccion=".$leccionActual.'")</script>';
}

?> 