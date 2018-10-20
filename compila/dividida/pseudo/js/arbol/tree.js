var gl = null;
var escena = null;

// GESTOR DE RECURSOS
var gestorRecursos = new TGestorRecursos();

// MATRIZ MODEL
var modelMatrix = mat4.create();
modelMatrix = mat4.identity(modelMatrix);

//CREACION DE VIEWMATRIX
var viewMatrix = mat4.create();
viewMatrix = mat4.identity(viewMatrix);

// MATRIZ DE PROYECCION
var pMatrix = mat4.create();
pMatrix = mat4.identity(pMatrix);

// CREACION DE PILA
// var aux = mat4.create();
// mat4.identity(aux);
var pilaMatrix = [];
// pilaMatrix.push(aux);

function apila(m){
    var copy = mat4.create();
    mat4.set(m, copy);
    pilaMatrix.push(copy);
}
function desapila(){
    if (pilaMatrix.length == 0) {
        throw "Invalid popMatrix!";
    }else{
        pilaMatrix.pop();
    }
}

class Tmotor{
    constructor(){
      this.escenasMotor = [];
    }

    getEscenas(){
        return this.escenasMotor;
    }
    setEscena(e){
        if(e != null && e instanceof Tescena){
            this.escenasMotor.push(e);
        }
    }

    tick(){
        requestAnimFrame(this.tick());
        for(var i=0; i<this.escenasMotor.length; i++){
            this.escenasMotor[i].drawEscena();
        }
    }
}

// MOTOR DE ESCENAS
var motor = new Tmotor();

  "use strict";
/************************************************* ESCENA *******************************************/
class Tescena{
    constructor(){
        this.treeNode = new Tnode(null, null, null);

        // CAMARAS ESCENA
        this.Tcamaras = [];
        // PARA SABER SI LA ESCENA TIENE UNA CAMARA PRINCIPAL
        this.mainCamera = null;

        // LUCES ESCENA
        this.Tluces = [];
        // ARRAY DE POSICIONES DE LAS LUCES
        this.TlightMatrix = [];
        // LUZ AMBIENTAL GENERAL PARA TODA LA ESCENA
        this.ambiental = [1.0, 1.0, 1.0];

        motor.setEscena(this);

        //ANIMACIONES INTERPOLADAS
        this.intAn = [];
    }

    //METODOS ARBOL ESCENA
    getTreeNode(){
        return this.treeNode;
    }

    resetTreeNode(){
        this.treeNode = new Tnode(null, null, null);
    }

    apilaIntAn(anim){
        this.intAn.push(anim);
    }

    drawEscena(){
        if(gl != null && this.treeNode.getHijos() != null && this.treeNode.getHijos().length > 0 && this.Tcamaras.length>0 && this.mainCamera != null){
            for(var x=0; x<this.intAn.length; x++){
                if(this.intAn[x] != null && this.intAn[x].getMaxWay() == null){
                    this.intAn[x].anima();
                }else{
                    this.intAn.splice(x, 1);
                }
            }
            var searchState = 0;
            while(searchState<3){
              switch (searchState) {
                //CALCULAMOS POSICION DE LAS CAMARAS
                case 0:
                  var ok; var actualNode; var nodesWayCamera; var aux;
                  for(var i=0; i<this.Tcamaras.length; i++){
                      if(this.Tcamaras[i].getEntidad() != null && this.Tcamaras[i].getEntidad() instanceof Tcamara){
                          nodesWayCamera = [];
                          //Anyadimos camara al vector
                          nodesWayCamera.push(this.Tcamaras[i]);
                          ok = false;
                          actualNode = this.Tcamaras[i];
                          while(!ok){
                            if(actualNode.getPadre() != null){
                              actualNode = actualNode.getPadre();
                              //Colocamos el padre al inicio del vector
                              nodesWayCamera.unshift(actualNode);
                            }else{
                              ok = true;
                            }
                          }
                          //multiplicamos las matrices de las transformaciones para calcular la posicion de la camara
                          aux = mat4.identity(mat4.create());
                          for(var j=0; j<nodesWayCamera.length; j++){
                              if(nodesWayCamera[j].getEntidad() != null){
                                  if(nodesWayCamera[j].getEntidad() instanceof Ttransf){
                                      aux = mat4.multiply(aux, nodesWayCamera[j].getEntidad().getMatrix(), mat4.create());
                                  }else if(nodesWayCamera[j].getEntidad() instanceof Tcamara){
                                      aux = mat4.inverse(aux, mat4.identity(mat4.create()));
                                      nodesWayCamera[j].getEntidad().setMatrix(aux);
                                      if(nodesWayCamera[j].getEntidad().getMain()){
                                          mat4.set(nodesWayCamera[j].getEntidad().getMatrix(), viewMatrix);
                                          mat4.set(nodesWayCamera[j].getEntidad().getPerspective(), pMatrix);
                                      }
                                  }
                              }
                          }
                        }else{
                            this.Tcamaras.splice(i,1);
                        }
                  }
                  break;
                //CALCULAMOS LA POSICION DE LAS LUCES
                case 1:
                  var nodesWayLuz; var ok; var actualNode; var aux;
                  this.TlightMatrix = [];
                  for(var i=0; i<this.Tluces.length; i++){
                      if(this.Tluces[i].getEntidad() != null && this.Tluces[i].getEntidad() instanceof Tluz){
                          nodesWayLuz = [];
                          //Anyadimos luz al vector
                          nodesWayLuz.push(this.Tluces[i]);
                          ok = false;
                          actualNode = this.Tluces[i];
                          while(!ok){
                              if(actualNode.getPadre() != null){
                                actualNode = actualNode.getPadre();
                                //Colocamos el padre al inicio del vector
                                nodesWayLuz.unshift(actualNode);
                              }else{
                                ok = true;
                              }
                          }
                          //multiplicamos las transformaciones para calcular la posicion de la luz
                          aux = mat4.create();
                          aux = mat4.identity(aux);
                          for(var j=0; j<nodesWayLuz.length; j++){
                              if(nodesWayLuz[j].getEntidad() != null){
                                  if(nodesWayLuz[j].getEntidad() instanceof Ttransf){
                                      aux = mat4.multiply(aux, nodesWayLuz[j].getEntidad().getMatrix(), mat4.create());
                                  }else if(nodesWayLuz[j].getEntidad() instanceof Tluz){
                                      this.setTlightMatrix([aux[12], aux[13], aux[14]]);
                                  }
                              }
                          }
                      }else{
                          this.Tluces.splice(i,1);
                      }
                  }
                  break;
                case 2:
                  //LE ASIGNO TAMANYO AL VIEWPORT Y RESETEO LA VENTANA
                  gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
                  gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

                  this.treeNode.drawNode();
                  break;
                default:
                  // statements_def
                  break;
              }
              searchState++;
            }
        }
    }

    /********************** METODOS PARA GESTION DE LAS CAMARAS DE LA ESCENA**********/
    getTcamaras(){
        return this.Tcamaras;
    }
    setCamara(c){
        if(c != null && c instanceof Tnode && c.getEntidad() != null && c.getEntidad() instanceof Tcamara){
            this.Tcamaras.push(c);
        }
    }

    getMainCamera(){
        return this.mainCamera;
    }
    setMainCamera(c){
        if(c != null && c instanceof Tnode && c.getEntidad() != null && c.getEntidad() instanceof Tcamara){
            if(this.mainCamera != null){
                this.mainCamera.getEntidad().changeMain();
                c.getEntidad().changeMain();
                this.mainCamera = c;
            }else{
                c.getEntidad().changeMain();
                this.mainCamera = c;
            }
        }
    }

    /********************** METODOS PARA GESTION DE LAS LUCES DE LA ESCENA************/
    getLuces(){
        return this.Tluces;
    }
    setLuz(l){
        if(l != null && l instanceof Tnode && l.getEntidad() != null && l.getEntidad() instanceof Tluz){
            this.Tluces.push(l);
        }
    }

    getLightMatrix(){
        return this.TlightMatrix;
    }
    setTlightMatrix(l){
        if(l != null){
            this.TlightMatrix.push(l);
        }
    }

    getAmbiental(){
        return this.ambiental;
    }
    setAmbiental(a){
        if(a != null && a.length == 3){
            vec3.set(a, this.ambiental);
        }
    }
} 
      