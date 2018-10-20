
  class Tanimacion extends Tentidad{
    constructor(){
        super();
        this.mallas = [];
        this.iterador = 0;
        this.lastTime = 0;
        this.tiempoBucle = 500;
    }

    setMallaAnimacion(nMalla, rem){
        if(rem){
            this.mallas = [];
        }
        for(var i=0; i<nMalla.length; i++){
            nMalla[i].cargar();
            nMalla[i].setTextura();
            this.mallas.push(nMalla[i]);
        }
    }

    setTiempoBucle(tb){
        this.tiempoBucle = tb;
    }

    beginDraw(){
        if(this.mallas != null && this.mallas.length > 0){
            var timeNow = new Date().getTime();
            if (this.lastTime != 0) {
                var elapsed = timeNow - this.lastTime;
                if(elapsed > this.tiempoBucle){                   
                  this.iterador++;
                  if(this.iterador >= this.mallas.length){
                      this.iterador = 0;
                  }
                  this.lastTime = timeNow;
                }
                this.mallas[this.iterador].beginDraw();
            }else{
                this.lastTime = timeNow;
            }
        }
    }

    endDraw(){}
  }