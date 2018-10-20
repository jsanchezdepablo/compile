
  /*************************************************CLASE INTERPOLACION*******************************************/
  class interpolacion{
    constructor(nodoT, maxWay, anim, tipo){
        this.bucle = true;    
        this.nodoT = nodoT;
        this.tipo = tipo;

        this.firstVecTrans = [anim[0], anim[1], anim[2]];
        this.vecTrans = [anim[0], anim[1], anim[2]];
        this.maxWay = maxWay;
        
        this.tiempoBucle = 0.1;
        this.lastTime = 0;
    }

    getBucle(){
        return this.bucle;
    }

    getMaxWay(){
        return this.maxWay;
    }

    anima(){
        var pasa = false;
        if(this.tipo == 'escalado'){
          pasa = true;
        }
        var ok = true;
        var ok1 = true;
        var ok2 = true;
        if(pasa){
          if(this.maxWay != null){
              if(this.firstVecTrans[0] < 1){
                if(this.maxWay[0] >= this.vecTrans[0]){
                  ok = false;
                }
              }else if(this.maxWay[0] <= this.vecTrans[0]){
                  ok = false;
              }
              if(this.firstVecTrans[1] < 1){
                if(this.maxWay[1] >= this.vecTrans[1]){
                  ok1 = false;
                }
              }else if(this.maxWay[1] <= this.vecTrans[1]){
                  ok1 = false;
              }
              if(this.firstVecTrans[2] < 1){
                if(this.maxWay[2] >= this.vecTrans[2]){
                  ok2 = false;
                }
              }else if(this.maxWay[2] <= this.vecTrans[2]){
                  ok2 = false;
              }
          }

          if(!ok && !ok1 && !ok2){
            this.bucle = false;
          }else{
            var timeNow = new Date().getTime();
            if (this.lastTime != 0) {
                var elapsed = timeNow - this.lastTime;
                if(elapsed > this.tiempoBucle){                   
                  if(this.maxWay != null){
                    if(ok){
                      this.vecTrans[0] = this.vecTrans[0] * this.firstVecTrans[0];
                    }
                    if(ok1){
                      this.vecTrans[1] = this.vecTrans[1] * this.firstVecTrans[1];
                    }
                    if(ok2){
                      this.vecTrans[2] = this.vecTrans[2] * this.firstVecTrans[2];
                    }
                  }else{
                    this.vecTrans[0] = this.vecTrans[0] * this.firstVecTrans[0];
                    this.vecTrans[1] = this.vecTrans[1] * this.firstVecTrans[1];
                    this.vecTrans[2] = this.vecTrans[2] * this.firstVecTrans[2];
                  }
                  this.nodoT.getEntidad().escala(this.firstVecTrans);
                  this.lastTime = timeNow;
                }
            }else{
              this.lastTime = timeNow;
            }
          }
        }else{
          if(this.maxWay != null){
              if(this.firstVecTrans[0] < 0){
                if(this.maxWay[0]*-1 >= this.vecTrans[0]){
                  ok = false;
                }
              }else if(this.maxWay[0] <= this.vecTrans[0]){
                  ok = false;
              }
              if(this.firstVecTrans[1] < 0){
                if(this.maxWay[1]*-1 >= this.vecTrans[1]){
                  ok1 = false;
                }
              }else if(this.maxWay[1] <= this.vecTrans[1]){
                  ok1 = false;
              }
              if(this.firstVecTrans[2] < 0){
                if(this.maxWay[2]*-1 >= this.vecTrans[2]){
                  ok2 = false;
                }
              }else if(this.maxWay[2] <= this.vecTrans[2]){
                  ok2 = false;
              }
          }

          if(!ok && !ok1 && !ok2){
            this.bucle = false;
          }else{
            var timeNow = new Date().getTime();
            if (this.lastTime != 0) {
                var elapsed = timeNow - this.lastTime;
                if(elapsed > this.tiempoBucle){                   
                  if(this.maxWay != null){
                    if(ok){
                      this.vecTrans[0] = this.vecTrans[0] + this.firstVecTrans[0];
                    }
                    if(ok1){
                      this.vecTrans[1] = this.vecTrans[1] + this.firstVecTrans[1];
                    }
                    if(ok2){
                      this.vecTrans[2] = this.vecTrans[2] + this.firstVecTrans[2];
                    }
                  }else{
                    this.vecTrans[0] = this.vecTrans[0] + this.firstVecTrans[0];
                    this.vecTrans[1] = this.vecTrans[1] + this.firstVecTrans[1];
                    this.vecTrans[2] = this.vecTrans[2] + this.firstVecTrans[2];
                  }
                  if(this.tipo == 'traslacion'){
                      this.nodoT.getEntidad().traslada(this.firstVecTrans);
                  }else if(this.tipo == 'rotacion'){
                      this.nodoT.getEntidad().rota(this.firstVecTrans);
                  }
                  this.lastTime = timeNow;
                }
            }else{
              this.lastTime = timeNow;
            }
          }
        }
      }
  }