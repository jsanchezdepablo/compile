var leccionActual = 0;
var canvas = null;
var solucionLeccion = [];
var finalizaLeccion = false;

// function getParameterByName(name){
//     url = window.location.href;
//     name = name.replace(/[\[\]]/g, "\\$&");
//     var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
//         results = regex.exec(url);
//     if (!results) return null;
//     if (!results[2]) return '';
//     return decodeURIComponent(results[2].replace(/\+/g, " "));
// }
function gestionaLeccion(name){
	 url = window.location.href;
     name = name.replace(/[\[\]]/g, "\\$&");
     var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
         results = regex.exec(url);
     if (!results) return null;
     if (!results[2]) return '';
     return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function iniciarWebGL(){
	if(leccionActual == 0){
		leccionActual = gestionaLeccion("leccion");
		leccionActual = parseInt(leccionActual);
		canvas = document.getElementById("consola");
		creaEscena(canvas);
	}
	if(leccionActual == 7){
		webGLStart2();
	}else{
		webGLStart();
	}
	getSolucion('graficos');
}

function resetWorld(){
	escena.resetTreeNode();
	nodosMalla = [];
	nodosCamara = [];
	nodosLuz = [];
	luzPseudoCodigo = null;
	cuadradosPseudoCodigo = [];
	pila_evento = [];
	modelMatrix = mat4.create();
	modelMatrix = mat4.identity(modelMatrix);

	viewMatrix = mat4.create();
	viewMatrix = mat4.identity(viewMatrix);

	pMatrix = mat4.create();
	pMatrix = mat4.identity(pMatrix);
	pilaMatrix = [];
	document.getElementById('respuesaAConsola').innerHTML = '<li><label for="mostrarConsola"><span class="fi-graph-horizontal"></span></label></li>';
	document.getElementById('terminal').value = '';
}

function webGLStart(){
	if(escena == null){
		return;
	}
	resetWorld();
	var vr = [0.0, 0.0, -40.0];
	var vr2 = [23.4, 180.0, -23.4];
	var vr3 = [0.0, 0.2, 0.0];

	nodosCamara.push(crearTraslacion(escena.getTreeNode(), [0.0,0.0,0.0])); 
	nodosCamara.push(crearRotacion(nodosCamara[0], [0.0, 0.0, 0.0]));
	var camaraPseudo = crearCamara(nodosCamara[1]);
	usarCamara(camaraPseudo);
	usaPerspectiva(camaraPseudo, 45, 0.1, 100.0);

	var iDif = [0.2, 0.2, 0.2];
	nodosLuz.push(crearTraslacion(escena.getTreeNode(), [-25.0, 0.0,0.0])); 
	luzPseudoCodigo = crearLuz(nodosLuz[0], iDif, iDif, null, null);
	ponerLuzAmbiental([0.8, 0.8, 0.8 ]);

	nodosMalla.push(crearTraslacion(escena.getTreeNode(), [0.0,0.0,-5.0])); 
	nodosMalla.push(crearEscalado(nodosMalla[0], [1, 1, 1]));
	if(leccionActual == 3 || leccionActual == 4){
		editarTransformacion(nodosMalla[1], [0.7,0.7,0.7], 'escalado');
		editarTransformacion(nodosMalla[1], [20.0,0.0,0.0], 'rotacion');
		var auxMalla = new Tmalla(escena, "pseudo/data/poliedro_convexo.json", "pseudo/img/cuadrado2.png");
		var auxArray = [];
			auxArray.push(auxMalla);
		mallaPseudoCodigo = crearAnimacion(nodosMalla[1], auxArray, 2000);
		crearInterpolacion(nodosMalla[0], null, [0.0, -0.4, 0.0], 'rotacion');
	}else if(leccionActual == 6){
		editarTransformacion(nodosMalla[1], [0.7,0.7,0.7], 'escalado');
		editarTransformacion(nodosMalla[1], [20.0,0.0,0.0], 'rotacion');
		var escx = crearEscalado(nodosMalla[1], [1.5, 1.0, 1.0]);
		crearMalla(escx, "pseudo/data/coordx.json", "pseudo/img/cuadrado3.png");
		var escy = crearEscalado(nodosMalla[1], [1.0, 1.0, 1.0]);
		crearMalla(escy, "pseudo/data/coordy.json", "pseudo/img/cuadrado2.png");
		var escz = crearEscalado(nodosMalla[1], [1.0, 1.0, 1.5]);
		crearMalla(escz, "pseudo/data/coordz.json", "pseudo/img/azul_oscuro.png");
		mallaPseudoCodigo = crearMalla(nodosMalla[1], "pseudo/data/coords.json", "pseudo/img/gris.png");
		crearInterpolacion(nodosMalla[0], null, [0.0, -0.4, 0.0], 'rotacion');
	}else if(leccionActual == 8){
		mallaPseudoCodigo = crearMalla(nodosMalla[1], "pseudo/data/pila.json", "pseudo/img/pilaback.png");
	}else{
		editarTransformacion(nodosMalla[1], [0.5,0.5,0.5], 'escalado');
		// editarTransformacion(nodosMalla[1], [20.0,0.0,0.0], 'rotacion');
		mallaPseudoCodigo = crearMalla(nodosMalla[1], "pseudo/data/pila.json", "pseudo/img/pilaback.png");
		crearInterpolacion(nodosMalla[0], null, [0.0, -0.4, 0.0], 'rotacion');
	}

	tick();
}

function webGLStart2(){
	if(escena == null){
		return;
	}
	resetWorld();
	var vr = [0.0, 0.0, -40.0];
	var vr2 = [23.4, 180.0, -23.4];
	var vr3 = [0.0, 0.2, 0.0];

	var esc = crearEscalado(escena.getTreeNode(), [.5, .5, .5]);
	var escenario = crearMalla(esc, "pseudo/data/world.json", "pseudo/img/escenario.png");

	nodosCamara.push(crearTraslacion(escena.getTreeNode(), [10.0,13.0,10.0])); 
	nodosCamara.push(crearRotacion(nodosCamara[0], [0.0, 45.0, 0.0]));
	editarTransformacion(nodosCamara[1], [-45.0, 0.0, 0.0], 'rotacion');
	var camaraPseudo = crearCamara(nodosCamara[1]);
	usarCamara(camaraPseudo);
	usaPerspectiva(camaraPseudo, 45, 0.1, 100.0);

	var iDif = [0.2, 0.2, 0.2];
	nodosLuz.push(crearTraslacion(escena.getTreeNode(), [-20.0, 0.0,0.0])); 
	luzPseudoCodigo = crearLuz(nodosLuz[0], iDif, iDif, null, null);
	ponerLuzAmbiental([0.8, 0.8, 0.8 ]);

	var tranC1 = crearTraslacion(escena.getTreeNode(), [-4.0,-5.0,-4.0]); 
	var escC1 = crearEscalado(tranC1, [10, 10, 10]);
	crearMalla(escC1, "pseudo/data/cuadrado.json", "pseudo/img/cuadrado3.png");
	cuadradosPseudoCodigo.push(tranC1);

	var tranC3 = crearTraslacion(escena.getTreeNode(), [-4.0,-4.0,-5.0]); 
	var rotC3 = crearRotacion(tranC3, [90.0, 0.0, 0.0]);
	var escC3 = crearEscalado(rotC3, [10, 10, 10]);
	crearMalla(escC3, "pseudo/data/cuadrado.json", "pseudo/img/cuadrado2.png");
	cuadradosPseudoCodigo.push(tranC3);

	var tranC2 = crearTraslacion(escena.getTreeNode(), [-5.0,-4.0,-4.0]); 
	var rotC2 = crearRotacion(tranC2, [0.0, 0.0, 90.0]);
	var escC2 = crearEscalado(rotC2, [10, 10, 10]);
	crearMalla(escC2, "pseudo/data/cuadrado.json", "pseudo/img/cuadrado1.png");
	cuadradosPseudoCodigo.push(tranC2);

	nodosMalla.push(crearTraslacion(escena.getTreeNode(), [-4.0,-3.0,-4.0])); 
	nodosMalla.push(crearEscalado(nodosMalla[0], [.8, .8, .8]));
	mallaPseudoCodigo = crearMalla(nodosMalla[1], "pseudo/data/pila.json", "pseudo/img/pilaback.png");
	crearInterpolacion(nodosMalla[1], null, [0.0, -0.4, 0.0], 'rotacion');

	tick();
}

function getSolucion(curso){
	var curso = 'graficos';
	solucionLeccion = [];
	if(curso == 'graficos'){
		switch (leccionActual) {
		case 1:
			var ejer = new Object();
			ejer.name = "ejercicio1";
			ejer.sol = [];
				ejer.sol.push("a=coincidentes");
				ejer.sol.push("b=paralelas");
				ejer.sol.push("c=perpendiculares");
				ejer.sol.push("d=secantes");
			ejer.done = false;
			solucionLeccion.push(ejer);

			var ejer2 = new Object();
			ejer2.name = "ejercicio2";
			ejer2.sol = [];
				ejer2.sol.push("recta");
			ejer2.done = false;
			solucionLeccion.push(ejer2);

			var ejer3 = new Object();
			ejer3.name = "ejercicio3";
			ejer3.sol = [];
				ejer3.sol.push("punto");
			ejer3.done = false;
			solucionLeccion.push(ejer3);

			var ejer4 = new Object();
			ejer4.name = "ejercicio4";
			ejer4.sol = [];
				ejer4.sol.push("a=si");
				ejer4.sol.push("b=si");
			ejer4.done = false;
			solucionLeccion.push(ejer4);
			break;
		case 2:
			var ejer = new Object();
			ejer.name = "ejercicio1";
			ejer.sol = [];
				ejer.sol.push("a=3,triangulo");
				ejer.sol.push("b=5,pentagono");
				ejer.sol.push("c=6,hexagono");
			ejer.done = false;
			solucionLeccion.push(ejer);

			var ejer2 = new Object();
			ejer2.name = "ejercicio2";
			ejer2.sol = [];
				ejer2.sol.push("60");
			ejer2.done = false;
			solucionLeccion.push(ejer2);

			var ejer3 = new Object();
			ejer3.name = "ejercicio3";
			ejer3.sol = [];
				ejer3.sol.push("circulo");
			ejer3.done = false;
			solucionLeccion.push(ejer3);
			break;
		case 3:
			var ejer = new Object();
			ejer.name = "ejercicio1";
			ejer.sol = [];
				ejer.sol.push("a=hexaedro");
				ejer.sol.push("b=tetraedro,octaedro,icosaedro");
				ejer.sol.push("c=dodecaedro");
			ejer.done = false;
			solucionLeccion.push(ejer);

			var ejer2 = new Object();
			ejer2.name = "ejercicio2";
			ejer2.sol = [];
				ejer2.sol.push("convexa");
			ejer2.done = false;
			solucionLeccion.push(ejer2);

			var ejer3 = new Object();
			ejer3.name = "ejercicio3";
			ejer3.sol = [];
				ejer3.sol.push("si");
			ejer3.done = false;
			solucionLeccion.push(ejer3);
			break;
		case 4:
			finalizaLeccion = true;
			break;
		case 5:
			var ejer = new Object();
			ejer.name = "ejercicio1";
			ejer.sol = [];
				ejer.sol.push("primercuadrante");
				ejer.sol.push("tercercuadrante");
			ejer.done = false;
			solucionLeccion.push(ejer);

			var ejer2 = new Object();
			ejer2.name = "ejercicio2";
			ejer2.sol = [];
				ejer2.sol.push("primercuadrante");
				ejer2.sol.push("cuartocuadrante");
				ejer2.sol.push("tercercuadrante");
				ejer2.sol.push("segundocuadrante");
			ejer2.done = false;
			solucionLeccion.push(ejer2);

			var ejer3 = new Object();
			ejer3.name = "ejercicio3";
			ejer3.sol = [];
				ejer3.sol.push("a=(-4,2)");
				ejer3.sol.push("b=(2,-4)");
			ejer3.done = false;
			solucionLeccion.push(ejer3);

			break;
		case 6:
			var ejer = new Object();
			ejer.name = "ejercicio1";
			ejer.sol = [];
				ejer.sol.push("8");
			ejer.done = false;
			solucionLeccion.push(ejer);
			break;
		default:
			break;
	}
	}
}