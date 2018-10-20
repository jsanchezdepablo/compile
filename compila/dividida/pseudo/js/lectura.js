/************************************************** LECTURA FICHERO *********************************************/
var nodosMalla = [];
var nodosCamara = [];
var nodosLuz = [];
luzPseudoCodigo = null;
var cuadradosPseudoCodigo = [];
var pila_evento = [];

function gestionar(){
	var comprobar = false;
	if(mallaPseudoCodigo){
		if(pila_evento.length > 0){
			if(pila_evento[0].inter != null){
				if(!pila_evento[0].inter.getBucle()){
					pila_evento.shift();
					if(pila_evento.length > 0){
						invocarMetodo();
					}else{
						comprobar = true;
					}
				}else{
					pila_evento[0].inter.anima();
					if(pila_evento[0].nombre == 'mover' && pila_evento[0].elemento == 'malla' && leccionActual == 7){
						pila_evento[0].quads[0].anima();
						pila_evento[0].quads[1].anima();
						pila_evento[0].quads[2].anima();
					}
				}
			}else if(pila_evento[0].inter == null){
				if(pila_evento[0].nombre == 'intensidadLuz'){
					editarLuz(luzPseudoCodigo, pila_evento[0].arg, pila_evento[0].arg, null, null);
					pila_evento.shift();
					if(pila_evento.length > 0){
						invocarMetodo();
					}else {
						comprobar = true;
					}
				}else{
					invocarMetodo();
				}
			}	
		}
		if(comprobar){
			document.getElementById('respuesaAConsola').innerHTML = '<li><label for="mostrarConsola"><span class="fi-graph-horizontal"></span></label></li>';
			if(leccionActual == 7 && !finalizaLeccion){
				if(
					(mallaPseudoCodigo.getEntidad().getPMalla()[12] >= 2.099 && mallaPseudoCodigo.getEntidad().getPMalla()[12] <= 2.2) 
					&& (mallaPseudoCodigo.getEntidad().getPMalla()[13] >= 1.099 && mallaPseudoCodigo.getEntidad().getPMalla()[13] <= 1.2)
					&& (mallaPseudoCodigo.getEntidad().getPMalla()[14] >= 2.099 && mallaPseudoCodigo.getEntidad().getPMalla()[14] <= 2.2)
				){
					finalizaLeccion = true;
					document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaCorrecta">Has conseguido llegar a la posición dada, lección finalizada, ¡Enhorabuena!</li>';
				}else{
					console.log(mallaPseudoCodigo.getEntidad().getPMalla());
					document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">La posicion del objeto aún no es correcta.</li>';
				}
			}else if(leccionActual == 8 && !finalizaLeccion){
				if(
					(mallaPseudoCodigo.getEntidad().getPMalla()[0] >= 3.937 && mallaPseudoCodigo.getEntidad().getPMalla()[0] <= 3.938) &&
					mallaPseudoCodigo.getEntidad().getPMalla()[1] == 0 &&
					mallaPseudoCodigo.getEntidad().getPMalla()[2] == 0 &&
					mallaPseudoCodigo.getEntidad().getPMalla()[3] == 0 &&
					mallaPseudoCodigo.getEntidad().getPMalla()[4] == 0 &&
					(mallaPseudoCodigo.getEntidad().getPMalla()[5] >= 0.027 && mallaPseudoCodigo.getEntidad().getPMalla()[5] <= 0.028) &&
					(mallaPseudoCodigo.getEntidad().getPMalla()[6] >= 3.937 && mallaPseudoCodigo.getEntidad().getPMalla()[6] <= 3.938) &&
					mallaPseudoCodigo.getEntidad().getPMalla()[7] == 0 &&
					mallaPseudoCodigo.getEntidad().getPMalla()[8] == 0 &&
					(mallaPseudoCodigo.getEntidad().getPMalla()[9] <= -3.937 && mallaPseudoCodigo.getEntidad().getPMalla()[9] >= -3.938) &&
					(mallaPseudoCodigo.getEntidad().getPMalla()[10] >= 0.027 && mallaPseudoCodigo.getEntidad().getPMalla()[10] <= 0.028) &&
					mallaPseudoCodigo.getEntidad().getPMalla()[11] == 0
					){
					finalizaLeccion = true;
					document.getElementById('respuesaAConsola').innerHTML = '<li class="salidaCorrecta">Has conseguido llegar a la posición dada, lección finalizada, ¡Enhorabuena!</li>';
				}else{
					console.log(mallaPseudoCodigo.getEntidad().getPMalla());
					document.getElementById('respuesaAConsola').innerHTML = '<li class="salidaError">La posicion del objeto aún no es correcta.</li>';
				}
			}
		}
	}
}

function invocarMetodo(){
	var metodo = pila_evento[0];
	switch (pila_evento[0].nombre) {
		case 'mover':
			var ok = false;
			var actualNode = null;
			var useQuad = false;
			if(pila_evento[0].elemento == 'malla'){
				actualNode = nodosMalla[0];
				useQuad = true;
			}else if(pila_evento[0].elemento == 'luz'){
				actualNode = nodosLuz[0];
			}else if(pila_evento[0].elemento == 'camara'){
				actualNode = nodosCamara[0];
			}else{
				actualNode = nodosMalla[0];
			}
			if(actualNode != null){
				var dir = null;
				var pas = null;
				switch (pila_evento[0].arg[0]) {
					case 'izquierda':
						dir = [-0.1, 0.0, 0.0];
						pas = [pila_evento[0].arg[1], 0.0, 0.0];
						break;
					case 'derecha':
						dir = [0.1, 0.0, 0.0];
						pas = [pila_evento[0].arg[1], 0.0, 0.0];
						break;
					case 'arriba':
						dir = [0.0, 0.1, 0.0];
						pas = [0.0, pila_evento[0].arg[1], 0.0];
						break;
					case 'abajo':
						dir = [0.0, -0.1, 0.0];
						pas = [0.0, pila_evento[0].arg[1], 0.0];
						break;
					case 'dentro':
						dir = [0.0, 0.0, -0.1];
						pas = [0.0, 0.0, pila_evento[0].arg[1]];
						break;
					case 'fuera':
						dir = [0.0, 0.0, 0.1];
						pas = [0.0, 0.0, pila_evento[0].arg[1]];
						break;
					default:
						// statements_def
						break;
				}

				pila_evento[0].inter = crearInterpolacion(actualNode, pas, dir, 'traslacion');
				pila_evento[0].inter.anima();
				if(useQuad && cuadradosPseudoCodigo.length > 0 && leccionActual == 7){
					pila_evento[0].quads.push(crearInterpolacion(cuadradosPseudoCodigo[0], [pas[0], 0.0, pas[2]], [dir[0], 0.0, dir[2]], 'traslacion'));
					pila_evento[0].quads.push(crearInterpolacion(cuadradosPseudoCodigo[1], [pas[0], pas[1], 0.0], [dir[0], dir[1], 0.0], 'traslacion'));
					pila_evento[0].quads.push(crearInterpolacion(cuadradosPseudoCodigo[2], [0.0, pas[1], pas[2]], [0.0, dir[1], dir[2]], 'traslacion'));
					pila_evento[0].quads[0].anima();
					pila_evento[0].quads[1].anima();
					pila_evento[0].quads[2].anima();
				}
			}
			break;

		case 'girar':
			var dir = null;
			var pas = null;
			var actualNode = null;
			if(pila_evento[0].elemento == 'malla'){
				actualNode = nodosMalla[1];
			}else if(pila_evento[0].elemento == 'camara'){
				actualNode = nodosCamara[1];
			}
			if(actualNode != null){
				switch (pila_evento[0].arg[0]) {
					case 'izquierdaX':
						dir = [-0.4, 0.0, 0.0];
						pas = [pila_evento[0].arg[1], 0.0, 0.0];
						break;
					case 'derechaX':
						dir = [0.4, 0.0, 0.0];
						pas = [pila_evento[0].arg[1], 0.0, 0.0];
						break;
					case 'izquierdaY':
						dir = [0.0, 0.4, 0.0];
						pas = [0.0, pila_evento[0].arg[1], 0.0];
						break;
					case 'derechaY':
						dir = [0.0, -0.4, 0.0];
						pas = [0.0, pila_evento[0].arg[1], 0.0];
						break;
					case 'izquierdaZ':
						dir = [0.0, 0.0, -0.4];
						pas = [0.0, 0.0, pila_evento[0].arg[1]];
						break;
					case 'derechaZ':
						dir = [0.0, 0.0, 0.4];
						pas = [0.0, 0.0, pila_evento[0].arg[1]];
						break;
					default:
						// statements_def
						break;
				}
				pila_evento[0].inter = crearInterpolacion(actualNode, pas, dir, 'rotacion');
				pila_evento[0].inter.anima();
			}
			
		break;

		case 'altura':
			var dir = null;
			var pas = null;
			var actualNode = nodosMalla[1];
			var tam = pila_evento[0].arg[1];
			switch (pila_evento[0].arg[0]) {
				case 'aumentar':
					if(tam < 1){
						tam = 1.0;
					}
					dir = [1.008, 1.008, 1.008];
					pas = [tam, tam, tam];
					break;
				case 'aumentarX':
					if(tam < 1){
						tam = 1.0;
					}
					dir = [1.008, 1.0, 1.0];
					pas = [tam, 1.0, 1.0];
					break;
				case 'aumentarY':
					if(tam < 1){
						tam = 1.0;
					}
					dir = [1.0, 1.008, 1.0];
					pas = [1.0, tam, 1.0];
					break;
				case 'aumentarZ':
					if(tam < 1){
						tam = 1.0;
					}
					dir = [1.0, 1.0, 1.008];
					pas = [1.0, 1.0, tam];
					break;
				case 'disminuir':
					if(tam <= 0){
						tam = 0.1;
					}else if(tam > 1){
						tam = 1.0;
					}
					dir = [0.992, 0.992, 0.992];
					pas = [tam, tam, tam];
					break;
				case 'disminuirX':
					if(tam <= 0){
						tam = 0.1;
					}else if(tam > 1){
						tam = 1.0;
					}
					dir = [0.992, 1.0, 1.0];
					pas = [tam, 1.0, 1.0];
					break;
				case 'disminuirY':
					if(tam <= 0){
						tam = 0.1;
					}else if(tam >= 1){
						tam = 1.0;
					}
					dir = [1.0, 0.992, 1.0];
					pas = [1.0, tam, 1.0];
					break;
				case 'disminuirZ':
					if(tam <= 0){
						tam = 0.1;
					}else if(tam >= 1){
						tam = 1.0;
					}
					dir = [1.0, 1.0, 0.992];
					pas = [1.0, 1.0, tam];
					break;
				default:
					// statements_def
					break;
			}
			pila_evento[0].inter = crearInterpolacion(actualNode, pas, dir, 'escalado');
			pila_evento[0].inter.anima();
		break;
		
		default:
			break;
	}
}

function mover(dir, pas, elemento){
	var accion = new Object();
	accion.nombre = 'mover';
	accion.arg = [];
	accion.arg.push(dir);
	accion.arg.push(pas);
	accion.elemento = elemento;
	accion.inter = null;
	accion.quads = [];
	pila_evento.push(accion);
}

function girar(dir, grad, elemento){
	var accion = new Object();
	accion.nombre = 'girar';
	accion.arg = [];
	accion.arg.push(dir);
	accion.arg.push(grad);
	accion.elemento = elemento;
	accion.inter = null;
	pila_evento.push(accion);
}

function altura(dir, cant){
	var accion = new Object();
	accion.nombre = 'altura';
	accion.arg = [];
	accion.arg.push(dir);
	accion.arg.push(cant);
	accion.elemento = null;
	accion.inter = null;
	pila_evento.push(accion);
}

function intensidadLuz(int){
	var accion = new Object();
	accion.nombre = 'intensidadLuz';
	accion.arg = int;
	accion.elemento = 'luz';
	accion.inter = null;
	pila_evento.push(accion);
}

function lecturaTextArea(caca){
	var texto = document.getElementById("terminal").value;
	document.getElementById('respuesaAConsola').innerHTML = '<li><label for="mostrarConsola"><span class="fi-graph-horizontal"></span></label></li>';
	texto = texto.trim();
	texto = texto.replace(/ /g, "");
	texto = texto.split(/\r?\n/g);
	if(leccionActual == 0){
		return;
	}
	if(leccionActual == 7 || leccionActual == 8){
		if(texto != null && texto != ''){
			var actual;
			for(var i=0; i<texto.length; i++){
				actual = texto[i];
				if(actual != ""){
					if(actual.includes("(")){
						actual = actual.split("(");
						if(actual[1].includes(")")){
							var args = actual[1].split(")")[0];
							var aPila = anadirAPila(actual[0], args);
							if(aPila != 1){
								switch (aPila) {
									case 0:
										document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': Metodo no existente.</li>';
										break;
									case 2:
										document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': Numero de parametros incorrecto.</li>';
										break;
									case 3:
										document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': Uno de los parametros es incorrecto.</li>';
										break;
									case 4:
										document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': Uno de los parametros es incorrecto, direccion no registrada.</li>';
										break;
									default:
										break;
								}
							}
						}else{
							document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': El parentesis debe cerrarse.</li>';
						}
					}else{
						document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error linea '+ i +': Los parametros del metodo deben ir entre parentesis.</li>';
					}
				}
			}
		}
	}else if(leccionActual < 7 && leccionActual > 0){
		pila_evento = [];
		var figurasACrear = [];
		if(texto != null && texto != ''){
			var actual;
			var linea = 0;
			for(var i=0; i<texto.length; i++){
				actual = texto[i];
				linea = i+1;
				if(actual != ""){
					if(actual.includes("(") && (leccionActual == 3 || leccionActual == 4)){
						figurasACrear.push(actual);
					}else{
						var found = false;
						for(var j=0; j<solucionLeccion.length && !found; j++){
							if(solucionLeccion[j].name == actual){
								found =true;
								var h = 0;
								var apartados = 0;
								while(h<solucionLeccion[j].sol.length){
									i++;
									linea = i+1;
									if(i<texto.length){
										actual = texto[i];
										if(actual != ""){
											if(solucionLeccion[j].sol[h] == actual){
												apartados++;
											}else{
												document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error en '+ solucionLeccion[j].name +': La respuesta de la línea '+ linea +' no es correcta.</li>';
											}
											h++;
										}
										if(actual.includes("ejercicio")){
											document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error en '+ solucionLeccion[j].name +': No se han respondido a todos los apartados del ejercicio.</li>';
											i--;
											actual = texto[i];
											break;
										}
									}else{
										document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error en '+ solucionLeccion[j].name +': No se han respondido a todos los apartados del ejercicio.</li>';					
										break;
									}
								}
								if(apartados >= solucionLeccion[j].sol.length){
									solucionLeccion[j].done = true;
									document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaCorrecta">Las respuestas del '+ solucionLeccion[j].name +' son correctas. </li>';
								}
							}
						}
						if(!found){
							document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error en linea '+ linea +': cadena desconocida.</li>';
						}
					}
				}
			}
			var todas = true;
			//alert(solucionLeccion.length);
			for(var i=0; i<solucionLeccion.length; i++){
				if(solucionLeccion[i].done == false){
					todas =false;
					document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Debes completar el '+ solucionLeccion[i].name +' para finalizar la lección.</li>';
				}
			}
			if(todas){
				finalizaLeccion = true;
				document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaCorrecta">Todos las respuestas son correctas, lección finalizada, ¡Enhorabuena!</li>';
			}else{
				document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Tienes ejercicios sin contestar o con respuestas incorrectas, en caso de dudas consulta el apartado de soluciones.</li>';
			}

			var respuesta = 0;
			var rem = true;
			for(var i=0; i<figurasACrear.length; i++){
				respuesta = crearFigura(figurasACrear[i], rem);
				if(respuesta == 0){
					rem = false;
				}else{
					document.getElementById('respuesaAConsola').innerHTML += '<li class="salidaError">Error en creacion de figura '+ i +'</li>';
				}
			}
		}
	}

	if(finalizaLeccion){
		var datos='id='+gestionaLeccion('id')+'&leccion='+gestionaLeccion('leccion')+'&email='+caca;
		ajax(datos);
		document.getElementById("alaba").classList.remove('disabled');
		document.getElementById("alaba").classList.add('activo');
		document.getElementById("alaba").disabled=false;
	}

}
function gestionaLeccion(name){
	 url = window.location.href;
     name = name.replace(/[\[\]]/g, "\\$&");
     var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
         results = regex.exec(url);
     if (!results) return null;
     if (!results[2]) return '';
     return decodeURIComponent(results[2].replace(/\+/g, " "));
}
function ajax(datos){
	console.log(datos);
	$.ajax({
        url: 'php/siguienteLeccion.php?'+ datos,  /// funcion.php?id1=jfjf&id2=jjf
        type: 'GET',
        data: 'iduser=12345',
        /*success: function(data) {
        	alert(data);
        },
        error: function(){
        	alert('Error!');
        }*/
  	});
}

function getParametros(args){
	if(args != null){
		args = args.split(",");
	}
	return args;
}

function anadirAPila(nombFun, args){
	var er = 0;
	if(nombFun != null){

		var accion = new Object();
		args = getParametros(args);
		if(args.length == 2){
			if(nombFun == 'mover'){
				args[1] = parseInt(args[1]);
				args[1] *= 2.07;
			}else{
				args[1] = parseFloat(args[1]);
			}
			if(!isNaN(args[1])){
				er = 1;
			}else{
				er = 3;
			}
		}else if(nombFun == 'intensidadLuz' && args.length == 3){
			args[0] = parseFloat(args[0]);
			args[1] = parseFloat(args[1]);
			args[2] = parseFloat(args[2]);
			if(!isNaN(args[0]) && !isNaN(args[1]) && !isNaN(args[2])){
				er = 1;
			}else{
				er = 3;
			}
		}else{
			er = 2;
		}

		if(er == 1){
			switch(nombFun){
				case 'mover':
					if(args[0] == 'derecha' || args[0] == 'izquierda' || 
						args[0] == 'arriba' || args[0] == 'abajo' ||
						args[0] == 'dentro' || args[0] == 'fuera'){

						mover(args[0], args[1], 'malla');
					}else{
						er = 4;
					}
					
					break;
				case 'girar':
					if(args[0] == 'izquierdaX' || args[0] == 'derechaX' || 
						args[0] == 'izquierdaY' || args[0] == 'derechaY' ||
						args[0] == 'izquierdaZ' || args[0] == 'derechaZ'){

						girar(args[0], args[1], 'malla');
					}else{
						er = 4;
					}
					break;
				case 'altura':
					if(args[0] == 'aumentar' || args[0] == 'disminuir' || 
						args[0] == 'aumentarX' || args[0] == 'disminuirX' ||
						args[0] == 'aumentarY' || args[0] == 'disminuirY' ||
						args[0] == 'aumentarZ' || args[0] == 'disminuirZ'){

						altura(args[0], args[1]);
					}else{
						er = 4;
					}
					altura(args[0], args[1]);
					break;
				case 'moverLuz':
					if(args[0] == 'derecha' || args[0] == 'izquierda' || 
						args[0] == 'arriba' || args[0] == 'abajo' ||
						args[0] == 'dentro' || args[0] == 'fuera'){

						mover(args[0], args[1], 'luz');
					}else{
						er = 4;
					}
					break;
				case 'intensidadLuz':
					intensidadLuz(args);
					break;
				case 'moverCamara':
					if(args[0] == 'derecha' || args[0] == 'izquierda' || 
						args[0] == 'arriba' || args[0] == 'abajo' ||
						args[0] == 'dentro' || args[0] == 'fuera'){

						mover(args[0], args[1], 'camara');
					}else{
						er = 4;
					}
					break;
				case 'girarCamara':
					if(args[0] == 'izquierdaX' || args[0] == 'derechaX' || 
						args[0] == 'izquierdaY' || args[0] == 'derechaY' ||
						args[0] == 'izquierdaZ' || args[0] == 'derechaZ'){

						girar(args[0], args[1], 'camara');
					}else{
						er = 4;
					}
					break;
				default:
					er = 0;
					break;
			}
		}
	}
	return er;
}

function crearFigura(fig, res){
	var er = 0;
	// console.log(res);
	if(!mallaPseudoCodigo instanceof Tanimacion){
		return;
	}
	switch (fig) {
		case 'crearCilindro()':
			var auxMalla = new Tmalla(escena, "pseudo/data/cilindro.json", "pseudo/img/cuadrado1.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearCono()':
			var auxMalla = new Tmalla(escena, "pseudo/data/cono.json", "pseudo/img/cuadrado2.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearCubo()':
			var auxMalla = new Tmalla(escena, "pseudo/data/cubo.json", "pseudo/img/cuadrado3.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearDodecaedro()':
			var auxMalla = new Tmalla(escena, "pseudo/data/dodecaedro.json", "pseudo/img/amarillo.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearEsfera()':
			var auxMalla = new Tmalla(escena, "pseudo/data/esfera.json", "pseudo/img/naranja.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearIcosaedro()':
			var auxMalla = new Tmalla(escena, "pseudo/data/icosaedro.json", "pseudo/img/morado.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearOctaedro()':
			var auxMalla = new Tmalla(escena, "pseudo/data/octaedro.json", "pseudo/img/azul_oscuro.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearPiramide()':
			var auxMalla = new Tmalla(escena, "pseudo/data/piramide.json", "pseudo/img/violeta.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearPrismaHexagonal()':
			var auxMalla = new Tmalla(escena, "pseudo/data/prisma_hexagonal.json", "pseudo/img/naranja.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearPrismaRectangular()':
			var auxMalla = new Tmalla(escena, "pseudo/data/prisma_rectangular.json", "pseudo/img/amarillo.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearPrismaTriangular()':
			var auxMalla = new Tmalla(escena, "pseudo/data/prisma_triangular.json", "pseudo/img/gris.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		case 'crearTetraedro()':
			var auxMalla = new Tmalla(escena, "pseudo/data/tetraedro.json", "pseudo/img/cuadrado3.png");
			var auxArray = [];
				auxArray.push(auxMalla);
			ponerArrayFrames(mallaPseudoCodigo, auxArray, res);
			break;
		default:
			er = 1;
			break;
	}
	return er;
}




