/*************************************************CLASE TNODO*******************************************/
class Tnode{
    constructor(entidad, hijos, padre){
        this.entidad = entidad;
        this.hijos = hijos;
        this.padre = padre;
        this.toRem = false;
    }

    getToRem(){
        return this.toRem;
    }

    changeToRem(){
        if(this.toRem){
            this.toRem = false;
        }else{
            this.toRem = true;
        }
    }

    remChild(){
        if(this.hijos.length != null){
          for(var i=0; i<this.hijos.length; i++){
            if(this.hijos[i].getToRem()){
              this.hijos[i].changeToRem();
              this.hijos.splice(i, 1);
            }
          }
        }
    }
    
    remTnode(){
      if(this.padre != null && this.padre.hasChild()){
        if(this.hasChild()){
          for(var i=0; i<this.hijos.length; i++){
            this.hijos[i].setPadre(padre);
            this.padre.addHijo(hijos[i]);
          }
        }
        var aux = this.padre.getHijos().indexOf(this); //indexOf -> obtener el indice del objeto pasado por parametros en el array
        this.padre.getHijos().splice(aux, 1); // splice -> borra x elemente en la posicion del array que le pases
      }else{
        if(this.hasChild()){
          for(var i=0; i<this.hijos.length; i++){
            this.hijos[i].setPadre(null);
          }
        }
      }
    }

    addHijo(nodo){
        var ok = false;
        if(nodo != null){
          if(this.entidad == null || this.entidad instanceof Ttransf){ 
            if(this.hijos == null){ 
              this.hijos = []; 
            }
            this.hijos.push(nodo);

            ok = true;
          }
        }
        return ok;
    }

    hasChild(){
        var ok = false;
        if(this.hijos != null && this.hijos.length > 0){
          ok = true;
        }
        return ok;
    }
    getHijos(){
        return this.hijos;
    }

    setEntidad(entidad){
        this.entidad = entidad;
    }
    getEntidad(){
        return this.entidad;
    }

    getPadre(){
        return this.padre;
    }
    setPadre(node){
        this.padre = node;
    }

    drawNode(){
        if(this.entidad != null){
            this.entidad.beginDraw();
        }
        for(var i=0; this.hijos != null && i<this.hijos.length; i++){
            this.hijos[i].drawNode();
        }
        if(this.entidad != null){
            this.entidad.endDraw();
        }
    }
}